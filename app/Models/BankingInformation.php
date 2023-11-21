<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\UserStamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BankingInformation
 *
 * @property int $id
 * @property int|null $family_nucleus_id
 * @property int|null $child_id
 * @property string $account_type
 * @property string $type_banking
 * @property string $name_bank
 * @property string $account number
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Child|null $child
 * @property User $user
 * @property FamilyNucleus|null $family_nucleus
 * @package App\Models
 * @property string $account number
 * @method static \Illuminate\Database\Eloquent\Builder|BankingInformation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankingInformation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankingInformation query()
 * @method static \Illuminate\Database\Eloquent\Builder|BankingInformation whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankingInformation whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankingInformation whereChildId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankingInformation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankingInformation whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankingInformation whereFamilyNucleusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankingInformation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankingInformation whereNameBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankingInformation whereTypeBanking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankingInformation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankingInformation whereUpdatedBy($value)
 * @mixin \Eloquent
 * @mixin IdeHelperBankingInformation
 */
final class BankingInformation extends Model
{

    use UserStamps;

    protected $table = 'banking_information';

    protected $casts = [
        'family_nucleus_id' => 'int',
        'child_id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'family_nucleus_id',
        'child_id',
        'account_type',
        'type_banking',
        'name_bank',
        'account number',
        'created_by',
        'updated_by'
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function family_nucleus()
    {
        return $this->belongsTo(FamilyNucleus::class);
    }
}
