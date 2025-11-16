package com.cruisemasters

import android.content.Intent
import android.content.SharedPreferences
import android.os.Bundle
import android.widget.Toast
import androidx.activity.viewModels
import androidx.appcompat.app.AppCompatActivity
import androidx.lifecycle.Observer
import com.cruisemasters.databinding.ActivityLoginBinding
import com.cruisemasters.viewmodel.LoginViewModel

class LoginActivity : AppCompatActivity() {

    private lateinit var binding: ActivityLoginBinding
    private val viewModel: LoginViewModel by viewModels()
    private lateinit var sharedPreferences: SharedPreferences

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityLoginBinding.inflate(layoutInflater)
        setContentView(binding.root)

        sharedPreferences = getSharedPreferences("user_prefs", MODE_PRIVATE)

        // Check if user is already logged in
        val userId = sharedPreferences.getInt("user_id", -1)
        if (userId != -1) {
            navigateToCarList()
            return
        }

        binding.loginButton.setOnClickListener {
            val email = binding.emailEditText.text.toString()
            val password = binding.passwordEditText.text.toString()

            if (email.isNotEmpty() && password.isNotEmpty()) {
                viewModel.login(email, password)
            } else {
                Toast.makeText(this, "Please fill all fields", Toast.LENGTH_SHORT).show()
            }
        }

        binding.signupButton.setOnClickListener {
            startActivity(Intent(this, SignupActivity::class.java))
        }

        viewModel.loginResult.observe(this, Observer { result ->
            result.onSuccess { user ->
                // Save user session
                sharedPreferences.edit()
                    .putInt("user_id", user.id)
                    .putString("user_email", user.email)
                    .apply()
                navigateToCarList()
            }.onFailure { exception ->
                Toast.makeText(this, exception.message ?: "Login failed", Toast.LENGTH_SHORT).show()
            }
        })
    }

    private fun navigateToCarList() {
        startActivity(Intent(this, CarListActivity::class.java))
        finish()
    }
}
