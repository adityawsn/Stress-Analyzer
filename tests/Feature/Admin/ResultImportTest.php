<?php

namespace Tests\Feature\Admin;

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ResultImportTest extends TestCase
{
    private const IMPORT_URL = '/hasil-kuesioner/impor';

    public function test_import_requires_a_file(): void
    {
        $response = $this->postImport();

        $response
            ->assertRedirect(self::IMPORT_URL)
            ->assertSessionHasErrors([
                'file' => 'Silakan pilih file CSV, TXT, XLSX, atau XLS untuk diimpor.',
            ]);
    }

    public function test_import_rejects_empty_file_with_validation_message(): void
    {
        $response = $this->postImport([
            'file' => UploadedFile::fake()->createWithContent('kosong.csv', ''),
        ]);

        $response
            ->assertRedirect(self::IMPORT_URL)
            ->assertSessionHasErrors([
                'file' => 'File yang diunggah kosong. Isi file terlebih dahulu sesuai template impor.',
            ]);
    }

    public function test_import_rejects_unsupported_file_extension(): void
    {
        $response = $this->postImport([
            'file' => UploadedFile::fake()->create('data.pdf', 1, 'application/pdf'),
        ]);

        $response
            ->assertRedirect(self::IMPORT_URL)
            ->assertSessionHasErrors([
                'file' => 'Format file tidak didukung. Gunakan file CSV, TXT, XLSX, atau XLS.',
            ]);
    }

    public function test_import_shows_error_when_file_columns_do_not_match_template(): void
    {
        $this->disableImportProtectionMiddleware();

        $file = UploadedFile::fake()->createWithContent(
            'data.csv',
            "nama,email\nAditya,aditya@example.com\n"
        );

        $response = $this
            ->followingRedirects()
            ->from(self::IMPORT_URL)
            ->post(self::IMPORT_URL, ['file' => $file]);

        $response
            ->assertOk()
            ->assertSeeText('Format file tidak sesuai template')
            ->assertSeeText('Kolom wajib yang belum ada');
    }

    private function postImport(array $data = []): TestResponse
    {
        $this->disableImportProtectionMiddleware();

        return $this
            ->from(self::IMPORT_URL)
            ->post(self::IMPORT_URL, $data);
    }

    private function disableImportProtectionMiddleware(): void
    {
        $this->withoutMiddleware([
            Authenticate::class,
            IsAdmin::class,
            PreventBackHistory::class,
            VerifyCsrfToken::class,
        ]);
    }
}
