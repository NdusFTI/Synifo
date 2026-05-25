package com.example.synifo

import android.content.Context
import android.content.SharedPreferences

class FavoriteManager(context: Context) {

    private val prefs: SharedPreferences =
        context.getSharedPreferences("synifo_favorites", Context.MODE_PRIVATE)

    fun getFavoriteIds(): Set<String> {
        val str = prefs.getString("ids", "") ?: ""
        if (str.isEmpty()) return emptySet()
        return str.split(",").map { it.trim() }.filter { it.isNotEmpty() }.toSet()
    }

    fun isFavorite(id: String): Boolean = getFavoriteIds().contains(id)

    fun toggleFavorite(id: String): Boolean {
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

    private fun save(ids: Set<String>) {
        prefs.edit().putString("ids", ids.joinToString(",")).apply()
    }
}
