package com.example.synifo

import androidx.test.ext.junit.runners.AndroidJUnit4
import androidx.test.platform.app.InstrumentationRegistry
import org.junit.Assert.*
import org.junit.Before
import org.junit.Test
import org.junit.runner.RunWith

@RunWith(AndroidJUnit4::class)
class SessionManagerTest {

    private lateinit var session: SessionManager

    @Before
    fun setup() {
        val context = InstrumentationRegistry.getInstrumentation().targetContext
        context.getSharedPreferences("synifo_session", 0).edit().clear().commit()
        session = SessionManager(context)
    }

    @Test
    fun loginSuccessAsAdmin() {
        val role = session.login("admin", "admin123")
        assertEquals(SessionManager.ROLE_ADMIN, role)
    }

    @Test
    fun loginFailsWhenPasswordWrong() {
        val role = session.login("admin", "wrong")
        assertNull(role)
    }

    @Test
    fun isLoggedInTrueAfterLogin() {
        session.login("user", "user123")
        assertTrue(session.isLoggedIn())
    }

    @Test
    fun isLoggedInFalseAfterLogout() {
        session.login("admin", "admin123")
        session.logout()
        assertFalse(session.isLoggedIn())
    }

    @Test
    fun isAdminCorrectBasedOnRole() {
        session.login("admin", "admin123")
        assertTrue(session.isAdmin())

        session.logout()
        session.login("user", "user123")
        assertFalse(session.isAdmin())
    }
}
