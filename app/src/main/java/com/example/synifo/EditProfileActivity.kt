package com.example.synifo

import android.os.Bundle
import android.widget.Button
import android.widget.EditText
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity

class EditProfileActivity : AppCompatActivity() {

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_edit_profile)
        supportActionBar?.setDisplayHomeAsUpEnabled(true)
        supportActionBar?.title = "Edit Profil"

        val session = SessionManager(this)

        val etDisplayName        = findViewById<EditText>(R.id.etDisplayName)
        val etPasswordBaru       = findViewById<EditText>(R.id.etPasswordBaru)
        val etKonfirmasiPassword = findViewById<EditText>(R.id.etKonfirmasiPassword)
        val btnSimpan            = findViewById<Button>(R.id.btnSimpanProfil)

        // Isi nama tampil saat ini
        etDisplayName.setText(session.getDisplayName())

        btnSimpan.setOnClickListener {
            val displayName   = etDisplayName.text.toString().trim()
            val pwdBaru       = etPasswordBaru.text.toString()
            val pwdKonfirmasi = etKonfirmasiPassword.text.toString()

            if (displayName.isEmpty()) {
                etDisplayName.error = "Nama tidak boleh kosong"
                return@setOnClickListener
            }

            // Validasi password hanya kalau diisi
            if (pwdBaru.isNotEmpty()) {
                if (pwdBaru.length < 6) {
                    etPasswordBaru.error = "Password minimal 6 karakter"
                    return@setOnClickListener
                }
                if (pwdBaru != pwdKonfirmasi) {
                    etKonfirmasiPassword.error = "Password tidak cocok"
                    return@setOnClickListener
                }
                session.changePassword(pwdBaru)
            }

            session.setDisplayName(displayName)
            Toast.makeText(this, "Profil berhasil diperbarui", Toast.LENGTH_SHORT).show()
            finish()
        }
    }

    override fun onSupportNavigateUp(): Boolean {
        onBackPressedDispatcher.onBackPressed()
        return true
    }
}
