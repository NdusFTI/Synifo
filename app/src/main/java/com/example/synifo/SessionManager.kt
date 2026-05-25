package com.example.synifo

import android.content.Context
import android.content.SharedPreferences

class SessionManager(context: Context) {

    private val prefs: SharedPreferences =
        context.getSharedPreferences("synifo_session", Context.MODE_PRIVATE)

    companion object {
        const val ROLE_ADMIN = "admin"
        const val ROLE_USER  = "user"

        private val DEFAULT_ACCOUNTS = mapOf(
            "admin" to Pair("admin123", ROLE_ADMIN),
            "user"  to Pair("user123",  ROLE_USER)
        )
    }

    fun login(username: String, password: String): String? {
        val lower   = username.lowercase()
        val account = DEFAULT_ACCOUNTS[lower] ?: return null
        // Cek password custom dulu, fallback ke default
        val storedPwd = prefs.getString("pwd_$lower", account.first)
        if (storedPwd != password) return null
        prefs.edit()
            .putBoolean("is_logged_in", true)
            .putString("username", lower)
            .putString("role", account.second)
            .apply()
        return account.second
    }

    fun logout() {
        val username = getUsername()
        val customPwd  = prefs.getString("pwd_$username", null)
        val customName = prefs.getString("display_name_$username", null)
        prefs.edit().clear().apply()
        customPwd?.let  { prefs.edit().putString("pwd_$username", it).apply() }
        customName?.let { prefs.edit().putString("display_name_$username", it).apply() }
    }

    fun isLoggedIn(): Boolean = prefs.getBoolean("is_logged_in", false)

    fun getUsername(): String    = prefs.getString("username", "") ?: ""
    fun getRole(): String        = prefs.getString("role", ROLE_USER) ?: ROLE_USER
    fun isAdmin(): Boolean       = getRole() == ROLE_ADMIN

    fun getDisplayName(): String {
        val username = getUsername()
        return prefs.getString("display_name_$username", username) ?: username
    }

    fun setDisplayName(name: String) {
        prefs.edit().putString("display_name_${getUsername()}", name).apply()
    }

    fun changePassword(newPassword: String) {
        prefs.edit().putString("pwd_${getUsername()}", newPassword).apply()
    }
}
