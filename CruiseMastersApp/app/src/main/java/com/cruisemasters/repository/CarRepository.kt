package com.cruisemasters.repository

import com.cruisemasters.data.AppDatabase
import com.cruisemasters.data.model.Car

class CarRepository(private val database: AppDatabase) {

    suspend fun getAllCars(): List<Car> {
        return database.carDao().getAllCars()
    }

    suspend fun getCarById(carId: Int): Car? {
        return database.carDao().getCarById(carId)
    }
}
