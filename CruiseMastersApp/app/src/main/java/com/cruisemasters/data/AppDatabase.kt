package com.cruisemasters.data

import android.content.Context
import androidx.room.Database
import androidx.room.Room
import androidx.room.RoomDatabase
import androidx.sqlite.db.SupportSQLiteDatabase
import com.cruisemasters.data.dao.*
import com.cruisemasters.data.model.*
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch

@Database(entities = [User::class, Car::class, Purchase::class, Booking::class], version = 1, exportSchema = false)
abstract class AppDatabase : RoomDatabase() {

    abstract fun userDao(): UserDao
    abstract fun carDao(): CarDao
    abstract fun purchaseDao(): PurchaseDao
    abstract fun bookingDao(): BookingDao

    companion object {
        @Volatile
        private var INSTANCE: AppDatabase? = null

        fun getDatabase(context: Context, scope: CoroutineScope): AppDatabase {
            return INSTANCE ?: synchronized(this) {
                val instance = Room.databaseBuilder(
                    context.applicationContext,
                    AppDatabase::class.java,
                    "cruisemasters_database"
                )
                .addCallback(CarDatabaseCallback(scope))
                .build()
                INSTANCE = instance
                instance
            }
        }
    }

    private class CarDatabaseCallback(
        private val scope: CoroutineScope
    ) : RoomDatabase.Callback() {

        override fun onCreate(db: SupportSQLiteDatabase) {
            super.onCreate(db)
            INSTANCE?.let { database ->
                scope.launch(Dispatchers.IO) {
                    populateDatabase(database.carDao())
                }
            }
        }

        suspend fun populateDatabase(carDao: CarDao) {
            // Pre-populate cars
            val cars = listOf(
                Car(1, "Audi A4", 2020, "15000", "$35000", "audi_a4"),
                Car(2, "BMW X5", 2019, "20000", "$45000", "bmw_x5"),
                Car(3, "Chevrolet Camaro", 2021, "10000", "$40000", "chevrolet_camaro"),
                Car(4, "Ford Mustang", 2022, "8000", "$38000", "ford_mustang"),
                Car(5, "Honda Civic", 2020, "12000", "$22000", "honda_civic"),
                Car(6, "Hyundai Elantra", 2019, "18000", "$20000", "hyundai_elantra"),
                Car(7, "Kia K5", 2021, "9000", "$25000", "kia_k5"),
                Car(8, "Lexus RX350", 2020, "14000", "$50000", "lexus_rx350"),
                Car(9, "Mazda CX5", 2019, "16000", "$28000", "mazda_cx5"),
                Car(10, "Mercedes C-Class", 2021, "11000", "$42000", "mercedes_c_class"),
                Car(11, "Nissan Altima", 2020, "13000", "$24000", "nissan_altima"),
                Car(12, "Subaru Outback", 2019, "17000", "$26000", "subaru_outback"),
                Car(13, "Toyota Camry", 2021, "9500", "$27000", "toyota_camry"),
                Car(14, "VW Arteon", 2020, "12500", "$32000", "vw_arteon"),
                Car(15, "Jeep Wrangler", 2022, "7000", "$35000", "jeep_wrangler"),
                Car(16, "Cadillac Escalade", 2021, "10500", "$60000", "cadillac_escalade")
            )
            carDao.insertCars(cars)
        }
    }
}
