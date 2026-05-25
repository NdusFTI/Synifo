# Synifo - Aplikasi Destinasi Wisata Jepang

Aplikasi Android untuk menampilkan dan mengelola data destinasi wisata Jepang.

## Fitur

- List destinasi wisata dengan RecyclerView
- Tambah data destinasi (nama, lokasi, kategori, deskripsi, rating, foto)
- Simpan gambar dari gallery ke internal storage
- Database SQLite untuk penyimpanan data

## Tech Stack

- Kotlin
- SQLite (SQLiteOpenHelper)
- RecyclerView + CardView
- Fragment-based navigation (Bottom Navigation)

## Cara Menjalankan

1. Buka project di Android Studio
2. Sync Gradle
3. Run di device/emulator (minSdk 28)


## Alur Permission

```
User tap "Pilih Gambar"
  → checkPermission()
    → Sudah granted? → openGallery()
    → Belum? → requestPermission()
      → User approve → openGallery()
      → User tolak → Toast "Permission ditolak"
  → User pilih gambar → copyToInternalStorage()
  → Simpan path lokal ke database
```
