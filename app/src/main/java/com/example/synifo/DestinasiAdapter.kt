package com.example.synifo

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import java.io.File

class DestinasiAdapter(
    private val listDestinasi: List<Destinasi>,
    private val onItemClick: (Destinasi) -> Unit = {}
) : RecyclerView.Adapter<DestinasiAdapter.ViewHolder>() {

    class ViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val tvNama: TextView = view.findViewById(R.id.itemNama)
        val tvLokasi: TextView = view.findViewById(R.id.itemLokasi)
        val tvKategori: TextView = view.findViewById(R.id.itemKategori)
        val tvRating: TextView = view.findViewById(R.id.itemRating)
        val imgFoto: ImageView = view.findViewById(R.id.itemFoto)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_destinasi, parent, false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        val item = listDestinasi[position]
        holder.tvNama.text = item.nama
        holder.tvLokasi.text = item.lokasi
        holder.tvKategori.text = item.kategori
        holder.tvRating.text = "⭐ ${item.rating}"

        val fotoSource: Any = when {
            item.foto.startsWith("http") -> item.foto
            item.foto.isNotEmpty() -> File(item.foto)
            else -> android.R.drawable.ic_menu_gallery
        }
        Glide.with(holder.itemView.context)
            .load(fotoSource)
            .placeholder(android.R.drawable.ic_menu_gallery)
            .error(android.R.drawable.ic_menu_gallery)
            .into(holder.imgFoto)

        holder.itemView.setOnClickListener { onItemClick(item) }
    }

    override fun getItemCount(): Int = listDestinasi.size
}
