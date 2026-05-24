package com.example.synifo

import android.content.Intent
import android.os.Bundle
import android.util.Log
import android.widget.Button
import android.widget.EditText
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity

class LoginActivity : AppCompatActivity() {

    private val TAG = "LifecycleCheck"
    private lateinit var session: SessionManager

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        Log.d(TAG, "LoginActivity - onCreate: Activity Dibuat")

        session = SessionManager(this)

        // Skip login kalau sudah login
        if (session.isLoggedIn()) {
            goToMain()
            return
        }

        setContentView(R.layout.activity_login)
        supportActionBar?.hide()

        val etUsername = findViewById<EditText>(R.id.etUsername)
        val etPassword = findViewById<EditText>(R.id.etPassword)
        val btnLogin   = findViewById<Button>(R.id.btnLogin)

        btnLogin.setOnClickListener {
            val username = etUsername.text.toString().trim()
            val password = etPassword.text.toString().trim()

            if (username.isEmpty()) { etUsername.error = "Isi username"; return@setOnClickListener }
            if (password.isEmpty()) { etPassword.error = "Isi password"; return@setOnClickListener }

            val role = session.login(username, password)
            if (role != null) {
                Log.d(TAG, "Login sukses: $username ($role)")
                goToMain()
            } else {
                Toast.makeText(this, "Username atau password salah", Toast.LENGTH_SHORT).show()
            }
        }
    }

    private fun goToMain() {
        startActivity(Intent(this, MainActivity::class.java))
        finish()
    }

    override fun onStart()   { super.onStart();   Log.d(TAG, "LoginActivity - onStart") }
    override fun onResume()  { super.onResume();  Log.d(TAG, "LoginActivity - onResume") }
    override fun onPause()   { super.onPause();   Log.d(TAG, "LoginActivity - onPause") }
    override fun onStop()    { super.onStop();    Log.d(TAG, "LoginActivity - onStop") }
    override fun onDestroy() { super.onDestroy(); Log.d(TAG, "LoginActivity - onDestroy") }
}
