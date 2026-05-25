package com.example.synifo

import org.junit.Assert.*
import org.junit.Test

class DestinasiTest {

    @Test
    fun createDestinasiCorrectly() {
        val d = Destinasi("1", "Gunung Fuji", "Shizuoka, Jepang", "Gunung", "Gunung tertinggi di Jepang", "4.9", "fuji.jpg")
        assertEquals("1", d.id)
        assertEquals("Gunung Fuji", d.nama)
        assertEquals("4.9", d.rating)
    }

    @Test
    fun equalWhenAllFieldsSame() {
        val d1 = Destinasi("1", "Kuil Fushimi Inari", "Kyoto, Jepang", "Kuil", "Kuil dengan gerbang torii merah", "4.7", "fushimi.jpg")
        val d2 = Destinasi("1", "Kuil Fushimi Inari", "Kyoto, Jepang", "Kuil", "Kuil dengan gerbang torii merah", "4.7", "fushimi.jpg")
        assertEquals(d1, d2)
    }

    @Test
    fun copyWithNewName() {
        val original = Destinasi("1", "Menara Tokyo", "Tokyo, Jepang", "Menara", "Ikon kota Tokyo", "4.8", "tokyo_tower.jpg")
        val copy = original.copy(nama = "Kastil Osaka")
        assertEquals("Kastil Osaka", copy.nama)
        assertEquals(original.id, copy.id)
    }
}
