package com.example.synifo

import android.content.Context

class FavoriteManager(context: Context) {

    private val db = DatabaseHelper(context)

    fun getFavoriteIds(): Set<String> = db.getFavoriteIds()

    fun isFavorite(id: String): Boolean = db.isFavorite(id)

    fun toggleFavorite(id: String): Boolean {
        return if (db.isFavorite(id)) {
            db.removeFavorite(id)
            false
        } else {
            db.addFavorite(id)
            true
        }
    }
}
