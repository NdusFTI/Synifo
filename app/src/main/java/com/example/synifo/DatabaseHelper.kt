package com.example.synifo

import android.content.Context
import android.database.sqlite.SQLiteDatabase
import android.database.sqlite.SQLiteOpenHelper

class DatabaseHelper(context: Context) :
    SQLiteOpenHelper(context, "synifo.db", null, 2) {

    override fun onCreate(db: SQLiteDatabase) {
        val query = """
            CREATE TABLE destinasi(
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nama TEXT,
                lokasi TEXT,
                kategori TEXT,
                deskripsi TEXT,
                rating TEXT,
                foto TEXT
            )
        """
        db.execSQL(query)
    }

    override fun onUpgrade(db: SQLiteDatabase, oldVersion: Int, newVersion: Int) {
        db.execSQL("DROP TABLE IF EXISTS destinasi")
        onCreate(db)
    }

    fun insertData(nama: String, lokasi: String, kategori: String, deskripsi: String, rating: String, foto: String) {
        val db = writableDatabase
        val query = """
            INSERT INTO destinasi(nama, lokasi, kategori, deskripsi, rating, foto)
            VALUES('$nama', '$lokasi', '$kategori', '$deskripsi', '$rating', '$foto')
        """
        db.execSQL(query)
    }

    fun getAllData(): List<Destinasi> {
        val list = mutableListOf<Destinasi>()
        val db = readableDatabase
        val cursor = db.rawQuery("SELECT * FROM destinasi", null)

        if (cursor.moveToFirst()) {
            do {
                val d = Destinasi(
                    cursor.getInt(0),
                    cursor.getString(1),
                    cursor.getString(2),
                    cursor.getString(3),
                    cursor.getString(4),
                    cursor.getString(5),
                    cursor.getString(6)
                )
                list.add(d)
            } while (cursor.moveToNext())
        }
        cursor.close()
        return list
    }
}
