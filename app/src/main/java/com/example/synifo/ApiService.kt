package com.example.synifo

import retrofit2.Call
import retrofit2.http.*

interface ApiService {
    @GET("destinasi")
    fun getDestinasi(): Call<List<Destinasi>>

    @POST("destinasi")
    fun tambahDestinasi(@Body destinasi: Destinasi): Call<Destinasi>

    @PUT("destinasi/{id}")
    fun updateDestinasi(@Path("id") id: String, @Body destinasi: Destinasi): Call<Destinasi>

    @DELETE("destinasi/{id}")
    fun deleteDestinasi(@Path("id") id: String): Call<Destinasi>
}
