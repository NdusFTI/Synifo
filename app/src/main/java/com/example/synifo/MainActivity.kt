package com.example.synifo

import android.os.Bundle
import android.util.Log
import androidx.appcompat.app.AppCompatActivity
import androidx.fragment.app.Fragment
import com.google.android.material.bottomnavigation.BottomNavigationView
import dagger.hilt.android.AndroidEntryPoint

@AndroidEntryPoint
class MainActivity : AppCompatActivity() {

    private val TAG = "LifecycleCheck"

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)
        Log.d(TAG, "onCreate: Activity Dibuat")

        val session = SessionManager(this)
        val bottomNav = findViewById<BottomNavigationView>(R.id.bottom_navigation)

        // Admin tidak punya tab Favorite
        bottomNav.menu.findItem(R.id.nav_favorite).isVisible = !session.isAdmin()

        if (savedInstanceState == null) {
            replaceFragment(DashboardFragment())
            bottomNav.selectedItemId = R.id.nav_dashboard
        }

        bottomNav.setOnItemSelectedListener { item ->
            when (item.itemId) {
                R.id.nav_dashboard -> { replaceFragment(DashboardFragment()); true }
                R.id.nav_destinasi -> { replaceFragment(DestinasiFragment()); true }
                R.id.nav_favorite  -> { replaceFragment(FavoriteFragment()); true }
                R.id.nav_profile   -> { replaceFragment(ProfileFragment()); true }
                else -> false
            }
        }
    }

    override fun onStart()   { super.onStart();   Log.d(TAG, "onStart: Activity Terlihat") }
    override fun onResume()  { super.onResume();  Log.d(TAG, "onResume: Activity Interaktif (Running)") }
    override fun onPause()   { super.onPause();   Log.d(TAG, "onPause: Activity Dijeda (Sebagian tertutup)") }
    override fun onStop()    { super.onStop();    Log.d(TAG, "onStop: Activity Berhenti (Tidak terlihat)") }
    override fun onDestroy() { super.onDestroy(); Log.d(TAG, "onDestroy: Activity Dihancurkan") }
    override fun onRestart() { super.onRestart(); Log.d(TAG, "onRestart: Activity Dijalankan Kembali") }

    private fun replaceFragment(fragment: Fragment) {
        supportFragmentManager.beginTransaction()
            .replace(R.id.frameLayout, fragment)
            .commit()
    }
}
