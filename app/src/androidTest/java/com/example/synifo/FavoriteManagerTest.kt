package com.example.synifo

import androidx.test.ext.junit.runners.AndroidJUnit4
import androidx.test.platform.app.InstrumentationRegistry
import org.junit.Assert.*
import org.junit.Before
import org.junit.Test
import org.junit.runner.RunWith

@RunWith(AndroidJUnit4::class)
class FavoriteManagerTest {

    private lateinit var favManager: FavoriteManager

    @Before
    fun setup() {
        val context = InstrumentationRegistry.getInstrumentation().targetContext
        context.getSharedPreferences("synifo_favorites", 0).edit().clear().commit()
        favManager = FavoriteManager(context)
    }

    @Test
    fun notFavoriteInitially() {
        assertFalse(favManager.isFavorite("dest_1"))
    }

    @Test
    fun addedToFavoriteAfterOneToggle() {
        favManager.toggleFavorite("dest_1")
        assertTrue(favManager.isFavorite("dest_1"))
    }

    @Test
    fun removedFromFavoriteAfterTwoToggles() {
        favManager.toggleFavorite("dest_1")
        favManager.toggleFavorite("dest_1")
        assertFalse(favManager.isFavorite("dest_1"))
    }

    @Test
    fun saveMultipleFavorites() {
        favManager.toggleFavorite("dest_1")
        favManager.toggleFavorite("dest_2")
        assertEquals(2, favManager.getFavoriteIds().size)
    }
}
