package com.example.synifo

import android.os.Parcelable
import kotlinx.parcelize.Parcelize

@Parcelize
data class Destinasi(
    val id: Int,
    val nama: String,
    val lokasi: String,
    val kategori: String,
    val deskripsi: String,
    val rating: String,
    val foto: String
) : Parcelable
