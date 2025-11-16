package com.cruisemasters.repository

import com.cruisemasters.data.AppDatabase
import com.cruisemasters.data.model.User

class UserRepository(private val database: AppDatabase) {

    suspend fun insertUser(user: User) {
        database.userDao().insertUser(user)
    }

    suspend fun getUserByEmailAndPassword(email: String, password: String): User? {
        return database.userDao().getUserByEmailAndPassword(email, password)
    }

    suspend fun getUserByEmail(email: String): User? {
        return database.userDao().getUserByEmail(email)
    }

    suspend fun getUserById(id: Int): User? {
        return database.userDao().getUserById(id)
    }
}
