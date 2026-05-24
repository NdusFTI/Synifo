package com.example.synifo

import android.os.Bundle
import android.util.Log
import android.widget.Button
import android.widget.ImageView
import android.widget.TextView
import androidx.appcompat.app.AppCompatActivity
import com.bumptech.glide.Glide
import java.io.File

class DetailDestinasiActivity : AppCompatActivity() {

    private val TAG = "LifecycleCheck"

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

        // Favorite — hanya tampil untuk user (bukan admin)
        val session = SessionManager(this)
        val btnFavorite = findViewById<Button>(R.id.btnFavorite)

        if (session.isAdmin()) {
            btnFavorite.visibility = android.view.View.GONE
        } else {
            val favManager = FavoriteManager(this)
            updateFavButton(btnFavorite, favManager.isFavorite(destinasi.id))

            btnFavorite.setOnClickListener {
                val nowFav = favManager.toggleFavorite(destinasi.id)
                updateFavButton(btnFavorite, nowFav)
            }
        }
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
