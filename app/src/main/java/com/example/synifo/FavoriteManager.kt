package com.example.synifo

import android.content.Context
import android.content.SharedPreferences

class FavoriteManager(context: Context) {

    private val prefs: SharedPreferences =
        context.getSharedPreferences("synifo_favorites", Context.MODE_PRIVATE)

    fun getFavoriteIds(): Set<Int> {
        val str = prefs.getString("ids", "") ?: ""
        if (str.isEmpty()) return emptySet()
        return str.split(",").mapNotNull { it.trim().toIntOrNull() }.toSet()
    }

    fun isFavorite(id: Int): Boolean = getFavoriteIds().contains(id)

    /** Returns true if now favorited, false if removed */
    fun toggleFavorite(id: Int): Boolean {
        val current = getFavoriteIds().toMutableSet()
        return if (current.contains(id)) {
            current.remove(id)
            save(current)
            false
        } else {
            current.add(id)
            save(current)
            true
        }
    }

    private fun save(ids: Set<Int>) {
        prefs.edit().putString("ids", ids.joinToString(",")).apply()
    }
}
