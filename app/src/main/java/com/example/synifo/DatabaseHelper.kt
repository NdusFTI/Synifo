package com.example.synifo

import android.content.Context
import android.database.sqlite.SQLiteDatabase
import android.database.sqlite.SQLiteOpenHelper

class DatabaseHelper(context: Context) :
    SQLiteOpenHelper(context, "synifo.db", null, 3) {

    override fun onCreate(db: SQLiteDatabase) {
        db.execSQL("""
            CREATE TABLE destinasi(
                id TEXT PRIMARY KEY,
                nama TEXT,
                lokasi TEXT,
                kategori TEXT,
                deskripsi TEXT,
                rating TEXT,
                foto TEXT
            )
        """)
    }

    override fun onUpgrade(db: SQLiteDatabase, oldVersion: Int, newVersion: Int) {
        db.execSQL("DROP TABLE IF EXISTS destinasi")
        onCreate(db)
    }

    fun insertData(id: String, nama: String, lokasi: String, kategori: String, deskripsi: String, rating: String, foto: String) {
        writableDatabase.execSQL(
            "INSERT OR REPLACE INTO destinasi(id,nama,lokasi,kategori,deskripsi,rating,foto) VALUES(?,?,?,?,?,?,?)",
            arrayOf(id, nama, lokasi, kategori, deskripsi, rating, foto)
        )
    }

    fun updateData(id: String, nama: String, lokasi: String, kategori: String, deskripsi: String, rating: String, foto: String) {
        writableDatabase.execSQL(
            "UPDATE destinasi SET nama=?,lokasi=?,kategori=?,deskripsi=?,rating=?,foto=? WHERE id=?",
            arrayOf(nama, lokasi, kategori, deskripsi, rating, foto, id)
        )
    }

    fun deleteData(id: String) {
        writableDatabase.execSQL("DELETE FROM destinasi WHERE id=?", arrayOf(id))
    }

    fun getAllData(): List<Destinasi> {
        val list = mutableListOf<Destinasi>()
        val cursor = readableDatabase.rawQuery("SELECT * FROM destinasi", null)
        if (cursor.moveToFirst()) {
            do {
                list.add(Destinasi(
                    cursor.getString(0),
                    cursor.getString(1),
                    cursor.getString(2),
                    cursor.getString(3),
                    cursor.getString(4),
                    cursor.getString(5),
                    cursor.getString(6)
                ))
            } while (cursor.moveToNext())
        }
        cursor.close()
        return list
    }
}
