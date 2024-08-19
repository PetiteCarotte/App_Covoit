<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $messages = $this->getMessages($user->id);
        $unreadCount = $this->getUnreadCount(); // Obtenez le nombre de messages non lus
        $filePath = storage_path("app/messages/{$user->id}.json");

        if (file_exists($filePath)) {
            $messages = json_decode(file_get_contents($filePath), true);

            // Trier les messages par date du plus récent au moins récent
            usort($messages, function ($a, $b) {
                $dateA = new \DateTime($a['timestamp']);
                $dateB = new \DateTime($b['timestamp']);
                return $dateB <=> $dateA; // Trier du plus récent au moins récent
            });
        } else {
            $messages = [];
        }

        // Réinitialiser le compteur de messages non lus
        $this->resetUnreadCount($user->id);

        // Passer la variable unreadCount à la vue du layout
        return view('messages.index', compact('messages', 'unreadCount'))
            ->with('unreadCount', $unreadCount); // Assurez-vous que 'unreadCount' est passé
    }

    private function getMessages($userId)
    {
        $filePath = storage_path("app/messages/{$userId}.json");
        if (file_exists($filePath)) {
            return json_decode(file_get_contents($filePath), true);
        }
        return [];
    }

    private function getUnreadCount()
    {
        $user = Auth::user();
        $countFilePath = storage_path("app/messages/{$user->id}_count.json");
        return file_exists($countFilePath) ? (int) file_get_contents($countFilePath) : 0;
    }

    private function resetUnreadCount($userId)
    {
        $countFilePath = storage_path("app/messages/{$userId}_count.json");
        if (file_exists($countFilePath)) {
            file_put_contents($countFilePath, 0);
        }
    }

    public function destroy($index)
    {
        $user = Auth::user();
        $filePath = storage_path("app/messages/{$user->id}.json");

        if (file_exists($filePath)) {
            $messages = json_decode(file_get_contents($filePath), true);
            if (isset($messages[$index])) {
                unset($messages[$index]);
                file_put_contents($filePath, json_encode(array_values($messages)));
            }
        }

        return redirect()->route('messages.index')->with('success', 'Message supprimé avec succès.');
    }
}
