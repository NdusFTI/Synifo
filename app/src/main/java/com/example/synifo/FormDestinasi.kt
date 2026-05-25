package com.example.synifo

import android.os.Bundle
import android.util.Base64
import android.util.Log
import android.widget.*
import androidx.activity.result.contract.ActivityResultContracts
import androidx.appcompat.app.AppCompatActivity
import com.bumptech.glide.Glide
import dagger.hilt.android.AndroidEntryPoint
import okhttp3.MultipartBody
import okhttp3.OkHttpClient
import okhttp3.Request
import okhttp3.Response as OkHttpResponse
import org.json.JSONObject
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.File
import java.io.FileOutputStream
import java.io.IOException
import javax.inject.Inject

@AndroidEntryPoint
class FormDestinasi : AppCompatActivity() {

    private val TAG = "LifecycleCheck"
    private val IMGBB_KEY = "b794fc3a08b1d285334c9a557e88c718"

    @Inject lateinit var apiService: ApiService

    lateinit var imgFoto: ImageView
    lateinit var btnFoto: Button
    var fotoPath: String = ""

    private var editDestinasi: Destinasi? = null

    val lokasiOptions = arrayOf(
        "Tokyo, Jepang", "Asakusa, Tokyo", "Kyoto, Jepang", "Shizuoka, Jepang",
        "Osaka, Jepang", "Himeji, Jepang", "Nara, Jepang", "Hiroshima, Jepang", "Kanagawa, Jepang"
    )
    val kategoriOptions = arrayOf(
        "Kuil", "Kastil", "Alam", "Taman", "Pulau", "Monumen", "Ikon Kota", "Menara Ikonik", "Museum"
    )

    private val pickImage = registerForActivityResult(ActivityResultContracts.GetContent()) { uri ->
        uri?.let {
            imgFoto.setImageURI(it)
            val file = copyToInternalStorage(it)
            uploadToImgBB(file)
        }
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_form_destinasi)
        Log.d(TAG, "FormDestinasi - onCreate: Activity Dibuat")

        supportActionBar?.setDisplayHomeAsUpEnabled(true)

        editDestinasi = intent.getParcelableExtra("destinasi")
        supportActionBar?.title = if (editDestinasi != null) "Edit Destinasi" else "Tambah Destinasi"

        val etNama     = findViewById<EditText>(R.id.etNama)
        val spLokasi   = findViewById<Spinner>(R.id.spLokasi)
        val spKategori = findViewById<Spinner>(R.id.spKategori)
        val etDeskripsi= findViewById<EditText>(R.id.etDeskripsi)
        val etRating   = findViewById<EditText>(R.id.etRating)
        val btnSimpan  = findViewById<Button>(R.id.btnSimpan)
        btnFoto = findViewById(R.id.btnPilihFoto)
        imgFoto = findViewById(R.id.imgFoto)
        spLokasi.adapter   = ArrayAdapter(this, android.R.layout.simple_spinner_dropdown_item, lokasiOptions)
        spKategori.adapter = ArrayAdapter(this, android.R.layout.simple_spinner_dropdown_item, kategoriOptions)

        editDestinasi?.let { d ->
            etNama.setText(d.nama)
            etDeskripsi.setText(d.deskripsi)
            etRating.setText(d.rating)
            val li = lokasiOptions.indexOf(d.lokasi)
            if (li >= 0) spLokasi.setSelection(li)
            val ki = kategoriOptions.indexOf(d.kategori)
            if (ki >= 0) spKategori.setSelection(ki)
            if (d.foto.isNotEmpty()) {
                fotoPath = d.foto
                Glide.with(this).load(d.foto).into(imgFoto)
                btnFoto.text = "Ganti Gambar"
            }
        }

        btnFoto.setOnClickListener {
            pickImage.launch("image/*")
        }

        btnSimpan.setOnClickListener {
            val nama      = etNama.text.toString().trim()
            val lokasi    = spLokasi.selectedItem.toString()
            val kategori  = spKategori.selectedItem.toString()
            val deskripsi = etDeskripsi.text.toString().trim()
            val rating    = etRating.text.toString().trim()

            if (nama.isEmpty())   { etNama.error = "Nama tidak boleh kosong"; return@setOnClickListener }
            if (rating.isEmpty()) { etRating.error = "Rating tidak boleh kosong"; return@setOnClickListener }
            if (!btnFoto.isEnabled) { Toast.makeText(this, "Tunggu upload foto selesai", Toast.LENGTH_SHORT).show(); return@setOnClickListener }

            btnSimpan.isEnabled = false
            btnSimpan.text = "Menyimpan..."

            val existing = editDestinasi
            if (existing != null) {
                val updated = existing.copy(nama = nama, lokasi = lokasi, kategori = kategori,
                    deskripsi = deskripsi, rating = rating, foto = fotoPath)
                apiService.updateDestinasi(existing.id, updated).enqueue(object : Callback<Destinasi> {
                    override fun onFailure(call: Call<Destinasi>, t: Throwable) {
                        selesai(btnSimpan, "Gagal memperbarui (API error)")
                    }
                    override fun onResponse(call: Call<Destinasi>, response: Response<Destinasi>) {
                        selesai(btnSimpan, "Data berhasil diperbarui")
                    }
                })
            } else {
                val baru = Destinasi("", nama, lokasi, kategori, deskripsi, rating, fotoPath)
                apiService.tambahDestinasi(baru).enqueue(object : Callback<Destinasi> {
                    override fun onFailure(call: Call<Destinasi>, t: Throwable) {
                        selesai(btnSimpan, "Gagal menyimpan (API error)")
                    }
                    override fun onResponse(call: Call<Destinasi>, response: Response<Destinasi>) {
                        selesai(btnSimpan, "Data berhasil disimpan")
                    }
                })
            }
        }
    }

    private fun uploadToImgBB(file: File) {
        btnFoto.isEnabled = false
        btnFoto.text = "Mengupload..."

        val base64 = Base64.encodeToString(file.readBytes(), Base64.DEFAULT)
        val body = MultipartBody.Builder()
            .setType(MultipartBody.FORM)
            .addFormDataPart("image", base64)
            .build()
        val request = Request.Builder()
            .url("https://api.imgbb.com/1/upload?key=$IMGBB_KEY")
            .post(body)
            .build()

        OkHttpClient().newCall(request).enqueue(object : okhttp3.Callback {
            override fun onFailure(call: okhttp3.Call, e: IOException) {
                runOnUiThread {
                    btnFoto.isEnabled = true
                    btnFoto.text = "Pilih Gambar"
                    Toast.makeText(this@FormDestinasi, "Upload gagal: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
            override fun onResponse(call: okhttp3.Call, resp: OkHttpResponse) {
                val responseBody = resp.body()?.string() ?: ""
                try {
                    val url = JSONObject(responseBody).getJSONObject("data").getString("url")
                    fotoPath = url
                    runOnUiThread {
                        btnFoto.isEnabled = true
                        btnFoto.text = "Ganti Gambar"
                        Glide.with(this@FormDestinasi).load(url).into(imgFoto)
                    }
                } catch (e: Exception) {
                    runOnUiThread {
                        btnFoto.isEnabled = true
                        btnFoto.text = "Pilih Gambar"
                        Toast.makeText(this@FormDestinasi, "Upload gagal, coba lagi", Toast.LENGTH_SHORT).show()
                    }
                }
            }
        })
    }

    private fun selesai(btnSimpan: Button, pesan: String) {
        runOnUiThread {
            Toast.makeText(this, pesan, Toast.LENGTH_SHORT).show()
            finish()
        }
    }

    private fun copyToInternalStorage(uri: android.net.Uri): File {
        val dir = File(filesDir, "images")
        if (!dir.exists()) dir.mkdirs()
        val file = File(dir, "img_${System.currentTimeMillis()}.jpg")
        contentResolver.openInputStream(uri)?.use { input ->
            FileOutputStream(file).use { output -> input.copyTo(output) }
        }
        return file
    }

    override fun onSupportNavigateUp(): Boolean { onBackPressedDispatcher.onBackPressed(); return true }

    override fun onStart()   { super.onStart();   Log.d(TAG, "FormDestinasi - onStart") }
    override fun onResume()  { super.onResume();  Log.d(TAG, "FormDestinasi - onResume") }
    override fun onPause()   { super.onPause();   Log.d(TAG, "FormDestinasi - onPause") }
    override fun onStop()    { super.onStop();    Log.d(TAG, "FormDestinasi - onStop") }
    override fun onDestroy() { super.onDestroy(); Log.d(TAG, "FormDestinasi - onDestroy") }
}
