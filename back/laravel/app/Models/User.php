<?php
    namespace App\Models;

    use Laravel\Sanctum\HasApiTokens;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;

    class User extends Authenticatable implements MustVerifyEmail {
        use HasFactory, Notifiable, HasApiTokens;

        protected $fillable = [
            'nom',
            'cognoms',
            'dni',
            'telefon',
            'email',
            'foto',
            'password',
            'curs',
            'torn',
            'rol',];

        protected $hidden = [
            'password',
            'remember_token',
        ];

        protected function casts(): array {
            return [
                'email_verified_at' => 'datetime',
                'password' => 'hashed',
            ];
        }

        public function alertas() {
            return $this->hasMany(Alerta::class);
        }

        public function rol() {
            return $this->belongsTo(Rol::class, 'rol', 'id');
        }

        public function curs() {
            return $this->belongsTo(Curs::class, 'curs', 'id');
        }

        public function torn() {
            return $this->belongsTo(Torn::class, 'torn', 'id');
        }

        public function sentMessages() {
            return $this->hasMany(Message::class, 'sender_id');
        }

        public function receivedMessages() {
            return $this->hasMany(Message::class, 'receiver_id');
        }
    }