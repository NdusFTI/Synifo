package com.example.synifo

import android.content.Intent
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ProgressBar
import androidx.fragment.app.Fragment
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import dagger.hilt.android.AndroidEntryPoint
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import javax.inject.Inject

@AndroidEntryPoint
class FavoriteFragment : Fragment() {

    @Inject
    lateinit var apiService: ApiService

    private lateinit var rvFavorite: RecyclerView
    private lateinit var progressBar: ProgressBar
    private lateinit var layoutEmpty: View

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        return inflater.inflate(R.layout.fragment_favorite, container, false)
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        rvFavorite  = view.findViewById(R.id.rvFavorite)
        progressBar = view.findViewById(R.id.progressBar)
        layoutEmpty = view.findViewById(R.id.layoutEmpty)
        rvFavorite.layoutManager = LinearLayoutManager(requireContext())
    }

    override fun onResume() {
        super.onResume()
        loadFavorites()
    }

    private fun loadFavorites() {
        progressBar.visibility = View.VISIBLE
        layoutEmpty.visibility = View.GONE

        val favoriteIds = FavoriteManager(requireContext()).getFavoriteIds()

        if (favoriteIds.isEmpty()) {
            progressBar.visibility = View.GONE
            layoutEmpty.visibility = View.VISIBLE
            rvFavorite.adapter = null
            return
        }

        apiService.getDestinasi().enqueue(object : Callback<List<Destinasi>> {
            override fun onFailure(call: Call<List<Destinasi>>, t: Throwable) {
                if (!isAdded) return
                progressBar.visibility = View.GONE
            }

            override fun onResponse(call: Call<List<Destinasi>>, response: Response<List<Destinasi>>) {
                if (!isAdded) return
                progressBar.visibility = View.GONE
                val all = response.body() ?: emptyList()
                val filtered = all.filter { it.id in favoriteIds }

                if (filtered.isEmpty()) {
                    layoutEmpty.visibility = View.VISIBLE
                    rvFavorite.adapter = null
                    return
                }

                rvFavorite.adapter = DestinasiAdapter(filtered) { destinasi ->
                    val intent = Intent(requireContext(), DetailDestinasiActivity::class.java)
                    intent.putExtra("destinasi", destinasi)
                    startActivity(intent)
                }
            }
        })
    }
}
