package com.example.synifo

import android.app.Activity
import android.content.Intent
import android.content.pm.PackageManager
import android.net.Uri
import android.os.Build
import android.os.Bundle
import android.util.Log
import android.view.View
import android.widget.*
import androidx.appcompat.app.AppCompatActivity
import androidx.core.app.ActivityCompat
import androidx.core.content.ContextCompat
import dagger.hilt.android.AndroidEntryPoint
import okhttp3.ResponseBody
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.File
import java.io.FileOutputStream
import javax.inject.Inject

@AndroidEntryPoint
class FormDestinasi : AppCompatActivity() {

    private val TAG = "LifecycleCheck"

    @Inject
    lateinit var apiService: ApiService

    lateinit var db: DatabaseHelper
    lateinit var imgFoto: ImageView
    lateinit var fotoPath: String
    val IMAGE_PICK = 100
    val PERM_REQUEST = 101

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_form_destinasi)
        Log.d(TAG, "FormDestinasi - onCreate: Activity Dibuat")

        supportActionBar?.setDisplayHomeAsUpEnabled(true)
        supportActionBar?.title = "Tambah Destinasi"

        val etNama = findViewById<EditText>(R.id.etNama)
        val spLokasi = findViewById<Spinner>(R.id.spLokasi)
        val spKategori = findViewById<Spinner>(R.id.spKategori)
        val etDeskripsi = findViewById<EditText>(R.id.etDeskripsi)
        val etRating = findViewById<EditText>(R.id.etRating)
        val btnSimpan = findViewById<Button>(R.id.btnSimpan)
        val btnFoto = findViewById<Button>(R.id.btnPilihFoto)

        imgFoto = findViewById(R.id.imgFoto)
        db = DatabaseHelper(this)

        val lokasi = arrayOf("Tokyo", "Kyoto", "Osaka", "Hiroshima", "Nara")
        val kategori = arrayOf("Kuil", "Museum", "Gunung", "Pulau", "Taman")

        spLokasi.adapter = ArrayAdapter(this, android.R.layout.simple_spinner_dropdown_item, lokasi)
        spKategori.adapter = ArrayAdapter(this, android.R.layout.simple_spinner_dropdown_item, kategori)

        btnFoto.setOnClickListener {
            if (checkPermission()) openGallery() else requestPermission()
        }

        btnSimpan.setOnClickListener {
            val nama = etNama.text.toString().trim()
            val lokasiValue = spLokasi.selectedItem.toString()
            val kategoriValue = spKategori.selectedItem.toString()
            val deskripsi = etDeskripsi.text.toString().trim()
            val rating = etRating.text.toString().trim()

            if (nama.isEmpty()) {
                etNama.error = "Nama tidak boleh kosong"
                return@setOnClickListener
            }
            if (rating.isEmpty()) {
                etRating.error = "Rating tidak boleh kosong"
                return@setOnClickListener
            }

            val fotoToSave = if (::fotoPath.isInitialized) fotoPath else ""

            btnSimpan.isEnabled = false
            btnSimpan.text = "Menyimpan..."

            simpanKeApi(nama, lokasiValue, kategoriValue, deskripsi, rating, fotoToSave, btnSimpan)
        }
    }

    private fun simpanKeApi(
        nama: String, lokasi: String, kategori: String,
        deskripsi: String, rating: String, foto: String,
        btnSimpan: Button
    ) {
        apiService.getDestinasi().enqueue(object : Callback<List<Destinasi>> {
            override fun onFailure(call: Call<List<Destinasi>>, t: Throwable) {
                Log.e(TAG, "Gagal fetch sebelum simpan: ${t.message}")
                // Tetap simpan ke SQLite meski API gagal
                simpanKeDb(nama, lokasi, kategori, deskripsi, rating, foto)
                selesai(btnSimpan, "Disimpan lokal (API tidak tersedia)")
            }

            override fun onResponse(call: Call<List<Destinasi>>, response: Response<List<Destinasi>>) {
                val currentList = response.body()?.toMutableList() ?: mutableListOf()
                val newId = (currentList.maxOfOrNull { it.id } ?: 0) + 1

                // foto di API kosong — local file path tidak bisa diakses device lain
                val newItem = Destinasi(newId, nama, lokasi, kategori, deskripsi, rating, "")

                currentList.add(newItem)

                apiService.updateDestinasi(currentList).enqueue(object : Callback<ResponseBody> {
                    override fun onFailure(call: Call<ResponseBody>, t: Throwable) {
                        Log.e(TAG, "Gagal PUT ke API: ${t.message}")
                        simpanKeDb(nama, lokasi, kategori, deskripsi, rating, foto)
                        selesai(btnSimpan, "Disimpan lokal (gagal update API)")
                    }

                    override fun onResponse(call: Call<ResponseBody>, response: Response<ResponseBody>) {
                        Log.d(TAG, "PUT API sukses: ${response.code()}")
                        simpanKeDb(nama, lokasi, kategori, deskripsi, rating, foto)
                        selesai(btnSimpan, "Data berhasil disimpan ke API")
                    }
                })
            }
        })
    }

    private fun simpanKeDb(nama: String, lokasi: String, kategori: String,
                           deskripsi: String, rating: String, foto: String) {
        db.insertData(nama, lokasi, kategori, deskripsi, rating, foto)
    }

    private fun selesai(btnSimpan: Button, pesan: String) {
        runOnUiThread {
            Toast.makeText(this, pesan, Toast.LENGTH_SHORT).show()
            finish()
        }
    }

    private fun checkPermission(): Boolean {
        val perm = if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.TIRAMISU)
            android.Manifest.permission.READ_MEDIA_IMAGES
        else android.Manifest.permission.READ_EXTERNAL_STORAGE
        return ContextCompat.checkSelfPermission(this, perm) == PackageManager.PERMISSION_GRANTED
    }

    private fun requestPermission() {
        val perm = if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.TIRAMISU)
            android.Manifest.permission.READ_MEDIA_IMAGES
        else android.Manifest.permission.READ_EXTERNAL_STORAGE
        ActivityCompat.requestPermissions(this, arrayOf(perm), PERM_REQUEST)
    }

    private fun openGallery() {
        val intent = Intent(Intent.ACTION_GET_CONTENT)
        intent.type = "image/*"
        startActivityForResult(Intent.createChooser(intent, "Pilih Gambar"), IMAGE_PICK)
    }

    override fun onRequestPermissionsResult(requestCode: Int, permissions: Array<out String>, grantResults: IntArray) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults)
        if (requestCode == PERM_REQUEST && grantResults.isNotEmpty() && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
            openGallery()
        } else {
            Toast.makeText(this, "Permission ditolak", Toast.LENGTH_SHORT).show()
        }
    }

    override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
        super.onActivityResult(requestCode, resultCode, data)
        if (requestCode == IMAGE_PICK && resultCode == Activity.RESULT_OK) {
            val uri: Uri? = data?.data
            if (uri != null) {
                imgFoto.setImageURI(uri)
                fotoPath = copyToInternalStorage(uri)
            }
        }
    }

    private fun copyToInternalStorage(uri: Uri): String {
        val dir = File(filesDir, "images")
        if (!dir.exists()) dir.mkdirs()
        val fileName = "img_${System.currentTimeMillis()}.jpg"
        val file = File(dir, fileName)
        contentResolver.openInputStream(uri)?.use { input ->
            FileOutputStream(file).use { output -> input.copyTo(output) }
        }
        return file.absolutePath
    }

    override fun onSupportNavigateUp(): Boolean {
        onBackPressedDispatcher.onBackPressed()
        return true
    }

    override fun onStart() { super.onStart(); Log.d(TAG, "FormDestinasi - onStart") }
    override fun onResume() { super.onResume(); Log.d(TAG, "FormDestinasi - onResume") }
    override fun onPause() { super.onPause(); Log.d(TAG, "FormDestinasi - onPause") }
    override fun onStop() { super.onStop(); Log.d(TAG, "FormDestinasi - onStop") }
    override fun onDestroy() { super.onDestroy(); Log.d(TAG, "FormDestinasi - onDestroy") }
}
