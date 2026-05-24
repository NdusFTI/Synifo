package com.example.synifo

import android.content.Intent
import android.os.Bundle
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Button
import android.widget.ImageView
import android.widget.TextView
import androidx.fragment.app.Fragment
import com.bumptech.glide.Glide
import com.google.android.material.chip.Chip
import com.google.android.material.chip.ChipGroup
import dagger.hilt.android.AndroidEntryPoint
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import javax.inject.Inject

@AndroidEntryPoint
class DashboardFragment : Fragment() {

    private val TAG = "LifecycleCheck"

    @Inject
    lateinit var apiService: ApiService

    private var topDestinasi: Destinasi? = null
    private var rootView: View? = null

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        Log.d(TAG, "DashboardFragment - onCreateView")
        rootView = inflater.inflate(R.layout.fragment_dashboard, container, false)
        return rootView
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        view.findViewById<Button>(R.id.btnTopDetail).setOnClickListener {
            topDestinasi?.let { d ->
                val intent = Intent(requireContext(), DetailDestinasiActivity::class.java)
                intent.putExtra("destinasi", d)
                startActivity(intent)
            }
        }
    }

    override fun onResume() {
        super.onResume()
        rootView?.let { loadDashboardData(it) }
    }

    private fun loadDashboardData(view: View) {
        val tvCountDestinasi = view.findViewById<TextView>(R.id.tvCountDestinasi)
        val tvCountLokasi    = view.findViewById<TextView>(R.id.tvCountLokasi)
        val tvCountKategori  = view.findViewById<TextView>(R.id.tvCountKategori)
        val tvAvgRating      = view.findViewById<TextView>(R.id.tvAvgRating)
        val tvTopNama        = view.findViewById<TextView>(R.id.tvTopNama)
        val tvTopDeskripsi   = view.findViewById<TextView>(R.id.tvTopDeskripsi)
        val imgTopFoto       = view.findViewById<ImageView>(R.id.imgTopFoto)
        val chipGroup        = view.findViewById<ChipGroup>(R.id.chipGroupKategori)

        apiService.getDestinasi().enqueue(object : Callback<List<Destinasi>> {
            override fun onFailure(call: Call<List<Destinasi>>, t: Throwable) {
                Log.e(TAG, "Dashboard API gagal: ${t.message}")
            }

            override fun onResponse(call: Call<List<Destinasi>>, response: Response<List<Destinasi>>) {
                if (!isAdded) return
                if (!response.isSuccessful) return
                val list = response.body() ?: return

                // Stats
                tvCountDestinasi.text = list.size.toString()
                tvCountLokasi.text    = list.map { it.lokasi }.distinct().size.toString()
                tvCountKategori.text  = list.map { it.kategori }.distinct().size.toString()

                val avgRating = list.mapNotNull { it.rating.toDoubleOrNull() }
                    .takeIf { it.isNotEmpty() }?.average()
                tvAvgRating.text = if (avgRating != null) String.format("%.1f", avgRating) else "-"

                // Top destinasi (rating tertinggi)
                val top = list.maxByOrNull { it.rating.toDoubleOrNull() ?: 0.0 }
                if (top != null) {
                    topDestinasi = top
                    tvTopNama.text = top.nama
                    tvTopDeskripsi.text = top.deskripsi.ifEmpty { "${top.lokasi} · ${top.kategori}" }

                    val fotoSource: Any = when {
                        top.foto.startsWith("http") -> top.foto
                        top.foto.isNotEmpty() -> java.io.File(top.foto)
                        else -> android.R.drawable.ic_menu_gallery
                    }
                    Glide.with(requireContext())
                        .load(fotoSource)
                        .placeholder(android.R.drawable.ic_menu_gallery)
                        .error(android.R.drawable.ic_menu_gallery)
                        .into(imgTopFoto)
                }

                // Chips kategori dinamis (nama kategori + jumlah)
                chipGroup.removeAllViews()
                val kategoriCount = list.groupBy { it.kategori }
                    .mapValues { it.value.size }
                    .toSortedMap()
                kategoriCount.forEach { (kategori, count) ->
                    val chip = Chip(requireContext())
                    chip.text = "$kategori ($count)"
                    chip.isClickable = false
                    chipGroup.addView(chip)
                }
            }
        })
    }
}
