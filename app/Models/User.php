<?php

    namespace App\Models;

    // use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Sanctum\HasApiTokens;

    class User extends Authenticatable
    {
        use HasApiTokens, HasFactory, Notifiable;

        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $fillable = [
            'name',
            'email',
            'password',
            'role',
        ];

        /**
         * The attributes that should be hidden for serialization.
         *
         * @var array<int, string>
         */
        protected $hidden = [
            'password',
            'remember_token',
        ];

        /**
         * The attributes that should be cast.
         *
         * @var array<string, string>
         */
        protected $casts = [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];

        public function reservations()
        {
            return $this->hasMany(Reservation::class);
        }

        public function occupantProfile()
        {
            return $this->hasOne(OccupantProfile::class, 'user_id');
        }

        public function dormitoryAgreement()
        {
            return $this->hasOne(DormitoryAgreement::class);
        }

        public function payments()
        {
            return $this->hasMany(Payment::class, 'user_id');
        }
        public function room()
        {
            return $this->belongsTo(Room::class);
        }
      
        public function paymentSchedules()
        {
            return $this->belongsToMany(PaymentSchedule::class, 'payment_schedule_user')
                        ->withPivot('additional_fee')
                        ->withTimestamps();
        }

        public function schedules()
        {
            return $this->belongsToMany(\App\Models\PaymentSchedule::class)->withPivot('total_due');
        }
        public function announcements()
        {
            return $this->belongsToMany(Announcement::class)->withTimestamps();
        }
    }
