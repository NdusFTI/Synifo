package com.example.synifo

import android.content.Context
import android.content.SharedPreferences

class SessionManager(context: Context) {

    private val prefs: SharedPreferences =
        context.getSharedPreferences("synifo_session", Context.MODE_PRIVATE)
    private val db = DatabaseHelper(context)

    companion object {
        const val ROLE_ADMIN = "admin"
        const val ROLE_USER  = "user"
    }

    fun login(username: String, password: String): String? {
        val lower = username.lowercase()
        val role  = db.validateUser(lower, password) ?: return null
        prefs.edit()
            .putBoolean("is_logged_in", true)
            .putString("username", lower)
            .putString("role", role)
            .apply()
        return role
    }

    fun logout() {
        prefs.edit().clear().apply()
    }

    fun isLoggedIn(): Boolean = prefs.getBoolean("is_logged_in", false)

    fun getUsername(): String = prefs.getString("username", "") ?: ""
    fun getRole(): String     = prefs.getString("role", ROLE_USER) ?: ROLE_USER
    fun isAdmin(): Boolean    = getRole() == ROLE_ADMIN

    fun getDisplayName(): String {
        val username = getUsername()
        return db.getDisplayName(username) ?: username
    }

    fun setDisplayName(name: String) {
        db.updateDisplayName(getUsername(), name)
    }

    fun changePassword(newPassword: String) {
        db.updatePassword(getUsername(), newPassword)
    }
}
