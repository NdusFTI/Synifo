package com.example.synifo

import android.content.Intent
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Button
import android.widget.ProgressBar
import android.widget.Toast
import androidx.fragment.app.Fragment
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import dagger.hilt.android.AndroidEntryPoint
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import javax.inject.Inject

@AndroidEntryPoint
class DestinasiFragment : Fragment() {

    @Inject
    lateinit var apiService: ApiService

    lateinit var rvDestinasi: RecyclerView
    lateinit var progressBar: ProgressBar
    lateinit var btnTambah: Button

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_home, container, false)

        btnTambah = view.findViewById(R.id.btnTambah)

        val session = SessionManager(requireContext())
        btnTambah.visibility = if (session.isAdmin()) View.VISIBLE else View.GONE

        btnTambah.setOnClickListener {
            startActivity(Intent(requireContext(), FormDestinasi::class.java))
        }

        return view
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        rvDestinasi = view.findViewById(R.id.rvDestinasi)
        progressBar = view.findViewById(R.id.progressBar)
        rvDestinasi.layoutManager = LinearLayoutManager(requireContext())
    }

    override fun onResume() {
        super.onResume()
        showDataDestinasi()
    }

    private fun showDataDestinasi() {
        progressBar.visibility = View.VISIBLE

        apiService.getDestinasi().enqueue(object : Callback<List<Destinasi>> {
            override fun onFailure(call: Call<List<Destinasi>>, t: Throwable) {
                progressBar.visibility = View.GONE
                Toast.makeText(requireContext(), "Gagal: ${t.message}", Toast.LENGTH_SHORT).show()
            }

            override fun onResponse(call: Call<List<Destinasi>>, response: Response<List<Destinasi>>) {
                progressBar.visibility = View.GONE
                if (response.isSuccessful) {
                    val listData = response.body()
                    if (listData != null) {
                        val adapter = DestinasiAdapter(listData) { destinasi ->
                            val intent = Intent(requireContext(), DetailDestinasiActivity::class.java)
                            intent.putExtra("destinasi", destinasi)
                            startActivity(intent)
                        }
                        rvDestinasi.adapter = adapter
                    }
                }
            }
        })
    }
}
