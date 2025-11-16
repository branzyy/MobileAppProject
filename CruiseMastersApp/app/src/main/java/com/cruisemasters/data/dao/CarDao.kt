package com.cruisemasters.data.dao

import androidx.room.Dao
import androidx.room.Insert
import androidx.room.OnConflictStrategy
import androidx.room.Query
import com.cruisemasters.data.model.Car

@Dao
interface CarDao {
    @Insert(onConflict = OnConflictStrategy.REPLACE)
    suspend fun insertCars(cars: List<Car>)

    @Query("SELECT * FROM cars ORDER BY carId ASC")
    suspend fun getAllCars(): List<Car>

    @Query("SELECT * FROM cars WHERE carId = :carId LIMIT 1")
    suspend fun getCarById(carId: Int): Car?
}
