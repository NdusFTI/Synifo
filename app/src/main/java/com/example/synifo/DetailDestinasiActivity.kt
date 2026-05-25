package com.example.synifo

import android.content.Intent
import android.os.Bundle
import android.util.Log
import android.view.View
import android.widget.Button
import android.widget.ImageView
import android.widget.TextView
import android.widget.Toast
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.app.AppCompatActivity
import com.bumptech.glide.Glide
import dagger.hilt.android.AndroidEntryPoint
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.File
import javax.inject.Inject

@AndroidEntryPoint
class DetailDestinasiActivity : AppCompatActivity() {

    private val TAG = "LifecycleCheck"

    @Inject lateinit var apiService: ApiService

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_detail_destinasi)
        Log.d(TAG, "DetailDestinasiActivity - onCreate: Activity Dibuat")

        supportActionBar?.setDisplayHomeAsUpEnabled(true)

        val destinasi = intent.getParcelableExtra<Destinasi>("destinasi") ?: return

        supportActionBar?.title = destinasi.nama

        findViewById<TextView>(R.id.tvDetailNama).text      = destinasi.nama
        findViewById<TextView>(R.id.tvDetailLokasi).text    = "📍 ${destinasi.lokasi}"
        findViewById<TextView>(R.id.tvDetailKategori).text  = destinasi.kategori
        findViewById<TextView>(R.id.tvDetailRating).text    = "⭐ ${destinasi.rating}"
        findViewById<TextView>(R.id.tvDetailDeskripsi).text =
            destinasi.deskripsi.ifEmpty { "Tidak ada deskripsi tersedia." }

        val imgFoto = findViewById<ImageView>(R.id.imgDetailFoto)
        val fotoSource: Any = when {
            destinasi.foto.startsWith("http") -> destinasi.foto
            destinasi.foto.isNotEmpty()       -> File(destinasi.foto)
            else                              -> android.R.drawable.ic_menu_gallery
        }
        Glide.with(this).load(fotoSource)
            .placeholder(android.R.drawable.ic_menu_gallery)
            .error(android.R.drawable.ic_menu_gallery)
            .into(imgFoto)

        val session    = SessionManager(this)
        val btnFavorite= findViewById<Button>(R.id.btnFavorite)
        val btnEdit    = findViewById<Button>(R.id.btnEdit)
        val btnHapus   = findViewById<Button>(R.id.btnHapus)

        if (session.isAdmin()) {
            btnFavorite.visibility = View.GONE
            btnEdit.visibility     = View.VISIBLE
            btnHapus.visibility    = View.VISIBLE

            btnEdit.setOnClickListener {
                val intent = Intent(this, FormDestinasi::class.java)
                intent.putExtra("destinasi", destinasi)
                startActivity(intent)
                finish()
            }

            btnHapus.setOnClickListener {
                AlertDialog.Builder(this)
                    .setTitle("Hapus Destinasi")
                    .setMessage("Hapus \"${destinasi.nama}\"?")
                    .setPositiveButton("Hapus") { _, _ -> hapusDestinasi(destinasi) }
                    .setNegativeButton("Batal", null)
                    .show()
            }
        } else {
            val favManager = FavoriteManager(this)
            updateFavButton(btnFavorite, favManager.isFavorite(destinasi.id))
            btnFavorite.setOnClickListener {
                val nowFav = favManager.toggleFavorite(destinasi.id)
                updateFavButton(btnFavorite, nowFav)
            }
        }
    }

    private fun hapusDestinasi(destinasi: Destinasi) {
        apiService.deleteDestinasi(destinasi.id).enqueue(object : Callback<Destinasi> {
            override fun onFailure(call: Call<Destinasi>, t: Throwable) {
                Toast.makeText(this@DetailDestinasiActivity, "Gagal menghapus (API error)", Toast.LENGTH_SHORT).show()
                finish()
            }
            override fun onResponse(call: Call<Destinasi>, response: Response<Destinasi>) {
                Toast.makeText(this@DetailDestinasiActivity, "Destinasi berhasil dihapus", Toast.LENGTH_SHORT).show()
                finish()
            }
        })
    }

    private fun updateFavButton(btn: Button, isFavorite: Boolean) {
        if (isFavorite) {
            btn.text = "❤ Hapus dari Favorit"
            btn.backgroundTintList =
                android.content.res.ColorStateList.valueOf(android.graphics.Color.parseColor("#E53935"))
        } else {
            btn.text = "🤍 Tambah ke Favorit"
            btn.backgroundTintList =
                android.content.res.ColorStateList.valueOf(android.graphics.Color.parseColor("#6C63FF"))
        }
    }

    override fun onStart()   { super.onStart();   Log.d(TAG, "DetailDestinasiActivity - onStart") }
    override fun onResume()  { super.onResume();  Log.d(TAG, "DetailDestinasiActivity - onResume") }
    override fun onPause()   { super.onPause();   Log.d(TAG, "DetailDestinasiActivity - onPause") }
    override fun onStop()    { super.onStop();    Log.d(TAG, "DetailDestinasiActivity - onStop") }
    override fun onDestroy() { super.onDestroy(); Log.d(TAG, "DetailDestinasiActivity - onDestroy") }
    override fun onRestart() { super.onRestart(); Log.d(TAG, "DetailDestinasiActivity - onRestart") }

    override fun onSupportNavigateUp(): Boolean {
        onBackPressedDispatcher.onBackPressed()
        return true
    }
}
