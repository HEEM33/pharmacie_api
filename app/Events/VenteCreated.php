<?php

namespace App\Events;

use App\Models\Vente;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class VenteCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $vente;

    /**
     * Crée une nouvelle instance d’événement.
     */
    public function __construct(Vente $vente)
    {
        $this->vente = $vente;
        Log::info('VenteCreated event instantiated for vente ' . $vente->id);
    }

    /**
     * Canal de diffusion.
     */
    public function broadcastOn(): PrivateChannel
    {
        // canal privé "ventes"
        return new PrivateChannel('ventes');
    }

    /**
     * Nom de l’événement côté frontend (optionnel)
     */
    public function broadcastAs()
    {
        return 'VenteCreated';
    }
    public function broadcastWith(): array
{
    return [
        'id' => $this->vente->id,
        'total' => $this->vente->total,
        'status' => $this->vente->status,
        'produits' => $this->vente->produits,
    ];
}

}
