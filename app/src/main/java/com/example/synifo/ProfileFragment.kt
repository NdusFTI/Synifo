package com.example.synifo

import android.content.Intent
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Button
import android.widget.TextView
import androidx.fragment.app.Fragment

class ProfileFragment : Fragment() {

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        return inflater.inflate(R.layout.fragment_profile, container, false)
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        bindData(view)
    }

    override fun onResume() {
        super.onResume()
        // Refresh nama tampil kalau baru dari EditProfile
        view?.let { bindData(it) }
    }

    private fun bindData(view: View) {
        val session     = SessionManager(requireContext())
        val displayName = session.getDisplayName()
        val username    = session.getUsername()
        val role        = session.getRole()

        view.findViewById<TextView>(R.id.tvAvatarInitial).text =
            displayName.firstOrNull()?.uppercase() ?: "?"
        view.findViewById<TextView>(R.id.tvProfileUsername).text  = displayName
        view.findViewById<TextView>(R.id.tvProfileSubtitle).text  = "@$username"
        view.findViewById<TextView>(R.id.tvProfileRole).text =
            if (role == SessionManager.ROLE_ADMIN) "Administrator" else "Pengguna"

        view.findViewById<Button>(R.id.btnEditProfil).setOnClickListener {
            startActivity(Intent(requireContext(), EditProfileActivity::class.java))
        }

        view.findViewById<Button>(R.id.btnLogout).setOnClickListener {
            session.logout()
            val intent = Intent(requireContext(), LoginActivity::class.java)
            intent.flags = Intent.FLAG_ACTIVITY_NEW_TASK or Intent.FLAG_ACTIVITY_CLEAR_TASK
            startActivity(intent)
        }
    }
}
