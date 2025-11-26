<?php

namespace mmerlijn\msgRepo\Enums;


trait StringEnumTrait
{
    public static function collection(): \Illuminate\Support\Collection
    {
        $collection = collect();
        foreach((new \ReflectionClass(static::class))->getConstants() as $item){
            $collection->push(collect(['value'=>$item->name,'label'=>self::as($item->name)]));
        };
        return $collection->sortBy('label')->values();
    }
    public static function array(): array
    {
        return self::collection()->mapWithKeys(fn($item) => [$item['value'] => $item['label']])->toArray();
    }
    public static function selectOptions(): array
    {
        return self::array();
    }

    public static function as($value): string
    {
        if(key_exists($value, self::labels())){
            return self::labels()[$value];
        }
        return match($value) {
            'NULL','_' => "",
            default => $value
        };
    }
    public static function labels(): array
    {
        return [];
    }

    public function lower(): string
    {
        return strtolower($this->name);
    }
    public function upper(): string
    {
        return strtoupper($this->name);
    }
    public function ucfirst(): string
    {
        return ucfirst($this->lower());
    }
    public static function values(): array
    {
        $a=[];
        foreach((new \ReflectionClass(static::class))->getConstants() as $item){
            $a[] = $item->value;
        };
        return $a;
    }
    public static function keys(): array
    {
        $a=[];
        foreach((new \ReflectionClass(static::class))->getConstants() as $item){
            $a[] = $item->name;
        };
        return $a;
    }
    public static function database(): array
    {
        return self::values();
    }

}
