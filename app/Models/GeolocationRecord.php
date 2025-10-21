<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeolocationRecord extends Model
{
    // Define the attributes that are mass assignable
    protected $fillable = [
        'work_id',        // ID of the associated work record
        'latitude',       // Latitude of the geolocation
        'longitude',      // Longitude of the geolocation
        'temperature',    // Temperature at the location
        'windspeed',      // Wind speed at the location
        'weather_code',   // Weather condition code
        'type',           // Type of geolocation record ['start', 'checkin', 'end']
        'recorded_at',    // Timestamp when the record was created
        'radius',        // Radius of the geolocation area
    ];

    // Weather descriptions mapped to weather codes
    public const WEATHER_DESCRIPTIONS = [
        0 => ['text' => "ท้องฟ้าแจ่มใส", 'icon' => "☀️"], // Clear sky
        1 => ['text' => "มีเมฆเล็กน้อย", 'icon' => "🌤️"], // Partly cloudy
        2 => ['text' => "มีเมฆปานกลาง", 'icon' => "⛅"], // Moderate clouds
        3 => ['text' => "มีเมฆมาก", 'icon' => "☁️"], // Overcast
        45 => ['text' => "หมอก", 'icon' => "🌫️"], // Fog
        48 => ['text' => "หมอกน้ำแข็ง", 'icon' => "🌫️❄️"], // Ice fog
        51 => ['text' => "ฝนปรอยเบา", 'icon' => "🌦️"], // Light drizzle
        53 => ['text' => "ฝนปานกลาง", 'icon' => "🌧️"], // Moderate rain
        55 => ['text' => "ฝนตกหนัก", 'icon' => "🌧️☔"], // Heavy rain
        61 => ['text' => "ฝนเล็กน้อย", 'icon' => "🌦️"], // Light rain
        63 => ['text' => "ฝนปานกลาง", 'icon' => "🌧️"], // Moderate rain
        65 => ['text' => "ฝนหนัก", 'icon' => "🌧️🌧️"], // Heavy rain
        80 => ['text' => "ฝนตกเป็นช่วง ๆ เล็กน้อย", 'icon' => "🌦️"], // Intermittent light rain
        81 => ['text' => "ฝนตกเป็นช่วง ๆ ปานกลาง", 'icon' => "🌧️🌦️"], // Intermittent moderate rain
        82 => ['text' => "ฝนตกเป็นช่วง ๆ หนัก", 'icon' => "🌧️🌧️🌩️"], // Intermittent heavy rain
        95 => ['text' => "พายุฝนฟ้าคะนอง", 'icon' => "⛈️"], // Thunderstorm
        96 => ['text' => "พายุพร้อมลูกเห็บเล็ก", 'icon' => "⛈️❄️"], // Thunderstorm with small hail
        99 => ['text' => "พายุพร้อมลูกเห็บหนัก", 'icon' => "⛈️🧊"], // Thunderstorm with heavy hail
    ];

    /**
     * Get the weather description based on the weather code.
     *
     * @return array An array containing the weather description text and icon.
     */
    public function getWeatherDescriptionAttribute()
    {
        // Return the weather description or a default value if the code is not found
        return self::WEATHER_DESCRIPTIONS[$this->weather_code] ?? ['text' => 'ไม่ทราบสภาพอากาศ', 'icon' => '❓'];
    }

    /**
     * Define a relationship to the WorkRecord model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workRecord()
    {
        // A geolocation record belongs to a single work record
        return $this->belongsTo(WorkRecord::class, 'work_id');
    }
}
