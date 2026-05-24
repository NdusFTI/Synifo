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

---

## Bug Fix Log

### Fix #1 - Crash saat buka list destinasi

**Masalah:** App crash saat membuka tab Destinasi setelah menambahkan data.

**Penyebab:** Database schema berubah (ditambah kolom `deskripsi` dan `rating`) tapi database version tidak di-bump. Table di device masih pakai schema lama, sehingga `cursor.getString(4)` crash karena kolom tidak ditemukan.

**Fix:** Bump database version dari `1` ke `2` di `DatabaseHelper.kt` agar `onUpgrade()` dijalankan dan table di-recreate.

```kotlin
// Sebelum
SQLiteOpenHelper(context, "synifo.db", null, 1)

// Sesudah
SQLiteOpenHelper(context, "synifo.db", null, 2)
```

### Fix #2 - Crash saat load gambar di RecyclerView

**Masalah:** App crash saat menampilkan item destinasi yang memiliki foto.

**Penyebab:** `setImageURI(Uri.parse(item.foto))` di adapter tidak memiliki error handling. Jika URI invalid atau permission belum di-grant, langsung crash.

**Fix:** Wrap `setImageURI` dalam `try-catch` di `DestinasiAdapter.kt`.

```kotlin
if (item.foto.isNotEmpty()) {
    try {
        val file = File(item.foto)
        if (file.exists()) {
            val bitmap = BitmapFactory.decodeFile(file.absolutePath)
            holder.imgFoto.setImageBitmap(bitmap)
        }
    } catch (e: Exception) {
        Log.e("DestinasiAdapter", "Gagal load gambar: ${e.message}")
    }
}
```

### Fix #3 - Permission untuk ambil gambar dari gallery

**Masalah:** App crash atau tidak bisa mengambil gambar karena tidak ada permission.

**Penyebab:** Tidak ada deklarasi permission di `AndroidManifest.xml` dan tidak ada runtime permission request.

**Fix:**

1. Tambah permission di `AndroidManifest.xml`:

```xml
<uses-permission android:name="android.permission.READ_EXTERNAL_STORAGE"
    android:maxSdkVersion="32" />
<uses-permission android:name="android.permission.READ_MEDIA_IMAGES" />
```

2. Runtime permission check di `FormDestinasi.kt`:

```kotlin
private fun checkPermission(): Boolean {
    val perm = if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.TIRAMISU) {
        android.Manifest.permission.READ_MEDIA_IMAGES
    } else {
        android.Manifest.permission.READ_EXTERNAL_STORAGE
    }
    return ContextCompat.checkSelfPermission(this, perm) == PackageManager.PERMISSION_GRANTED
}
```

### Fix #4 - Gambar pilih 2 kali di device Xiaomi/MIUI

**Masalah:** Setelah pilih gambar dari gallery, picker terbuka lagi (harus pilih 2 kali).

**Penyebab:** `ACTION_PICK` di MIUI/Xiaomi membuka 2 layer picker (system chooser lalu gallery).

**Fix:** Ganti ke `ACTION_GET_CONTENT` + `Intent.createChooser` di `FormDestinasi.kt`:

```kotlin
// Sebelum
val intent = Intent(Intent.ACTION_PICK)
intent.type = "image/*"
startActivityForResult(intent, IMAGE_PICK)

// Sesudah
val intent = Intent(Intent.ACTION_GET_CONTENT)
intent.type = "image/*"
startActivityForResult(Intent.createChooser(intent, "Pilih Gambar"), IMAGE_PICK)
```

### Fix #5 - Gambar tidak muncul saat render ulang di RecyclerView

**Masalah:** Gambar yang sudah dipilih tidak muncul saat list destinasi dibuka kembali.

**Penyebab:** URI dari `ACTION_PICK` bersifat temporary — permission bisa expired setelah activity selesai.

**Fix:** Copy gambar ke internal storage app saat dipilih, simpan path lokal ke database:

```kotlin
private fun copyToInternalStorage(uri: Uri): String {
    val dir = File(filesDir, "images")
    if (!dir.exists()) dir.mkdirs()

    val fileName = "img_${System.currentTimeMillis()}.jpg"
    val file = File(dir, fileName)

    contentResolver.openInputStream(uri)?.use { input ->
        FileOutputStream(file).use { output ->
            input.copyTo(output)
        }
    }
    return file.absolutePath
}
```

Di adapter, load dari file lokal:

```kotlin
val file = File(item.foto)
if (file.exists()) {
    val bitmap = BitmapFactory.decodeFile(file.absolutePath)
    holder.imgFoto.setImageBitmap(bitmap)
}
```

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
