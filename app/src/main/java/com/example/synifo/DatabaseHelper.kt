package com.example.synifo

import android.content.Context
import android.database.sqlite.SQLiteDatabase
import android.database.sqlite.SQLiteOpenHelper

class DatabaseHelper(context: Context) :
    SQLiteOpenHelper(context, "synifo.db", null, 4) {

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
        db.execSQL("""
            CREATE TABLE users(
                username     TEXT PRIMARY KEY,
                password     TEXT NOT NULL,
                role         TEXT NOT NULL,
                display_name TEXT
            )
        """)
        seedDefaultUsers(db)
    }

    override fun onUpgrade(db: SQLiteDatabase, oldVersion: Int, newVersion: Int) {
        if (oldVersion < 4) {
            db.execSQL("""
                CREATE TABLE IF NOT EXISTS users(
                    username     TEXT PRIMARY KEY,
                    password     TEXT NOT NULL,
                    role         TEXT NOT NULL,
                    display_name TEXT
                )
            """)
            seedDefaultUsers(db)
        }
    }

    private fun seedDefaultUsers(db: SQLiteDatabase) {
        db.execSQL("INSERT OR IGNORE INTO users(username,password,role) VALUES('admin','admin123','admin')")
        db.execSQL("INSERT OR IGNORE INTO users(username,password,role) VALUES('user','user123','user')")
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

    fun validateUser(username: String, password: String): String? {
        val cursor = readableDatabase.rawQuery(
            "SELECT role FROM users WHERE username=? AND password=?",
            arrayOf(username, password)
        )
        val role = if (cursor.moveToFirst()) cursor.getString(0) else null
        cursor.close()
        return role
    }

    fun updatePassword(username: String, newPassword: String) {
        writableDatabase.execSQL(
            "UPDATE users SET password=? WHERE username=?",
            arrayOf(newPassword, username)
        )
    }

    fun getDisplayName(username: String): String? {
        val cursor = readableDatabase.rawQuery(
            "SELECT display_name FROM users WHERE username=?",
            arrayOf(username)
        )
        val name = if (cursor.moveToFirst()) cursor.getString(0) else null
        cursor.close()
        return name
    }

    fun updateDisplayName(username: String, displayName: String) {
        writableDatabase.execSQL(
            "UPDATE users SET display_name=? WHERE username=?",
            arrayOf(displayName, username)
        )
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
