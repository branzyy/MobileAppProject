package com.cruisemasters.viewmodel

import android.app.Application
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.cruisemasters.data.AppDatabase
import com.cruisemasters.data.model.User
import com.cruisemasters.repository.UserRepository
import kotlinx.coroutines.launch

class LoginViewModel(application: Application) : AndroidViewModel(application) {

    private val repository: UserRepository
    private val _loginResult = MutableLiveData<Result<User>>()
    val loginResult: LiveData<Result<User>> get() = _loginResult

    init {
        val database = AppDatabase.getDatabase(application, viewModelScope)
        repository = UserRepository(database)
    }

    fun login(email: String, password: String) {
        viewModelScope.launch {
            try {
                val user = repository.getUserByEmailAndPassword(email, password)
                if (user != null) {
                    _loginResult.value = Result.success(user)
                } else {
                    _loginResult.value = Result.failure(Exception("Invalid credentials"))
                }
            } catch (e: Exception) {
                _loginResult.value = Result.failure(e)
            }
        }
    }

    fun signup(firstname: String, lastname: String, email: String, password: String) {
        viewModelScope.launch {
            try {
                val existingUser = repository.getUserByEmail(email)
                if (existingUser != null) {
                    _loginResult.value = Result.failure(Exception("Email already exists"))
                } else {
                    val user = User(firstname = firstname, lastname = lastname, email = email, password = password)
                    repository.insertUser(user)
                    _loginResult.value = Result.success(user)
                }
            } catch (e: Exception) {
                _loginResult.value = Result.failure(e)
            }
        }
    }
}
