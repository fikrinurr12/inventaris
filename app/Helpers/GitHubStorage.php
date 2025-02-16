<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class GitHubStorage
{
    protected static $username = 'fikrinurr12'; // Ganti dengan username GitHub Anda
    protected static $repo = 'inventaris'; // Nama repository tempat menyimpan gambar
    protected static $branch = 'master'; // Gunakan branch utama
    protected static $token = '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'; // Masukkan GitHub PAT

    public static function uploadImage($file, $path)
    {
        $fileContent = base64_encode(file_get_contents($file));
        $fileName = time() . '_' . $file->getClientOriginalName();

        $url = "https://api.github.com/repos/" . self::$username . "/" . self::$repo . "/contents/" . $path . "/" . $fileName;

        $response = Http::withHeaders([
            'Authorization' => 'token ' . self::$token,
            'Accept' => 'application/vnd.github.v3+json',
        ])->put($url, [
            'message' => "Upload image: $fileName",
            'content' => $fileContent,
            'branch' => self::$branch
        ]);

        if ($response->successful()) {
            return $response->json()['content']['download_url']; // URL gambar yang bisa diakses
        }

        return null;
    }

    public static function deleteImage($filePath)
    {
        $url = "https://api.github.com/repos/" . self::$username . "/" . self::$repo . "/contents/" . $filePath;

        // Ambil SHA file untuk menghapusnya
        $response = Http::withHeaders([
            'Authorization' => 'token ' . self::$token,
            'Accept' => 'application/vnd.github.v3+json',
        ])->get($url);

        if ($response->failed()) {
            return false;
        }

        $sha = $response->json()['sha'];

        $deleteResponse = Http::withHeaders([
            'Authorization' => 'token ' . self::$token,
            'Accept' => 'application/vnd.github.v3+json',
        ])->delete($url, [
            'message' => "Delete image: $filePath",
            'sha' => $sha,
            'branch' => self::$branch
        ]);

        return $deleteResponse->successful();
    }
}
