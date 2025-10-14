<?php
namespace App\Services;

use App\Models\Avatar;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class UserService
{ 
    /**
     * Actualizar los datos del usuario
     */
    public function updateUser(User $user, array $data): User
    {
        $user->update($data);
        return $user->fresh();
    }
    /**
     * Actualizar el avatar para el usuario
     */
    public function updateUserAvatar(User $user, UploadedFile $file): Avatar
    {
        // Generar nombre único
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        // Guardar archivo
        $path = $file->storeAs('avatars', $filename, 'public');

        // Crear avatar inicialmente como inactivo (para cumplir con el flujo)
        $avatar = Avatar::create([
            'user_id' => $user->id,
            'filename' => $filename,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'path' => $path,
            'is_active' => false,
        ]);

        // 👉 Desactivar anteriores y activar este
        return $this->setActiveAvatar($avatar);
    }


    /**
     * Eliminar un avatar
     */
    public function deleteAvatar(Avatar $avatar): bool
    {
        // Eliminar archivo físico
        if (Storage::disk('public')->exists($avatar->path)) {
            Storage::disk('public')->delete($avatar->path);
        }

        // Eliminar registro de base de datos
        return $avatar->delete();
    }

    /**
     * Activar un avatar y desactivar los demás del usuario
     */
    public function setActiveAvatar(Avatar $avatar): Avatar
    {
        // Desactivar todos los avatars del usuario
        $this->deactivateAllAvatars($avatar->user);

        // Activar el avatar seleccionado
        $avatar->update(['is_active' => true]);

        return $avatar->fresh();
    }

    /**
     * Desactivar todos los avatars de un usuario
     */
    public function deactivateAllAvatars(User $user): void
    {
        $user->avatars()->update(['is_active' => false]);
    }

}