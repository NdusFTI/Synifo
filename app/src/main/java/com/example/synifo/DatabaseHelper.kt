package com.example.synifo

import android.content.Context
import android.database.sqlite.SQLiteDatabase
import android.database.sqlite.SQLiteOpenHelper

class DatabaseHelper(context: Context) :
    SQLiteOpenHelper(context, "synifo.db", null, 5) {

    override fun onCreate(db: SQLiteDatabase) {
        db.execSQL("""
            CREATE TABLE users(
                username     TEXT PRIMARY KEY,
                password     TEXT NOT NULL,
                role         TEXT NOT NULL,
                display_name TEXT
            )
        """)
        db.execSQL("CREATE TABLE favorites(destinasi_id TEXT PRIMARY KEY)")
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
        if (oldVersion < 5) {
            db.execSQL("DROP TABLE IF EXISTS destinasi")
            db.execSQL("CREATE TABLE IF NOT EXISTS favorites(destinasi_id TEXT PRIMARY KEY)")
        }
    }

    private fun seedDefaultUsers(db: SQLiteDatabase) {
        db.execSQL("INSERT OR IGNORE INTO users(username,password,role) VALUES('admin','admin123','admin')")
        db.execSQL("INSERT OR IGNORE INTO users(username,password,role) VALUES('user','user123','user')")
    }

    fun addFavorite(destinasiId: String) {
        writableDatabase.execSQL(
            "INSERT OR IGNORE INTO favorites(destinasi_id) VALUES(?)", arrayOf(destinasiId)
        )
    }

    fun removeFavorite(destinasiId: String) {
        writableDatabase.execSQL("DELETE FROM favorites WHERE destinasi_id=?", arrayOf(destinasiId))
    }

    fun isFavorite(destinasiId: String): Boolean {
        val cursor = readableDatabase.rawQuery(
            "SELECT 1 FROM favorites WHERE destinasi_id=?", arrayOf(destinasiId)
        )
        val found = cursor.moveToFirst()
        cursor.close()
        return found
    }

    fun getFavoriteIds(): Set<String> {
        val set = mutableSetOf<String>()
        val cursor = readableDatabase.rawQuery("SELECT destinasi_id FROM favorites", null)
        if (cursor.moveToFirst()) {
            do { set.add(cursor.getString(0)) } while (cursor.moveToNext())
        }
        cursor.close()
        return set
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

}
