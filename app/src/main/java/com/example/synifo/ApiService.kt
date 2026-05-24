package com.example.synifo

import okhttp3.ResponseBody
import retrofit2.Call
import retrofit2.http.Body
import retrofit2.http.GET
import retrofit2.http.PUT

interface ApiService {
    @GET("7d7dec245f023ac2bbe5")
    fun getDestinasi(): Call<List<Destinasi>>

    @PUT("7d7dec245f023ac2bbe5")
    fun updateDestinasi(@Body list: List<Destinasi>): Call<ResponseBody>
}
