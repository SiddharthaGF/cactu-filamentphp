<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\UserStamps;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class BankingInformation
 *
 * @property int $banking_informationable_id
 * @property string $banking_informationable_type
 * @property string $financial_institution_types
 * @property string $financial_institution_bank
 * @property-read Model|Eloquent $banking_informationable
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $account_number
 *
 * @method static Builder|BankingInformation newModelQuery()
 * @method static Builder|BankingInformation newQuery()
 * @method static Builder|BankingInformation query()
 * @method static Builder|BankingInformation whereAccountNumber($value)
 * @method static Builder|BankingInformation whereAccountType($value)
 * @method static Builder|BankingInformation whereChildId($value)
 * @method static Builder|BankingInformation whereCreatedAt($value)
 * @method static Builder|BankingInformation whereCreatedBy($value)
 * @method static Builder|BankingInformation whereFamilyNucleusId($value)
 * @method static Builder|BankingInformation whereId($value)
 * @method static Builder|BankingInformation whereNameBank($value)
 * @method static Builder|BankingInformation whereTypeBanking($value)
 * @method static Builder|BankingInformation whereUpdatedAt($value)
 * @method static Builder|BankingInformation whereUpdatedBy($value)
 * @method static Builder|BankingInformation whereBankingInformationableId($value)
 * @method static Builder|BankingInformation whereBankingInformationableType($value)
 * @method static Builder|BankingInformation whereFinancialInstitutionBank($value)
 * @method static Builder|BankingInformation whereFinancialInstitutionTypes($value)
 *
 * @mixin Eloquent
 */
final class BankingInformation extends Model
{
    use UserStamps;

    protected $table = 'banking_information';

    protected $casts = [
        'banking_informationable_id' => 'int',
        'banking_informationable_type' => 'string',
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'account_type',
        'financial_institution_types',
        'financial_institution_bank',
        'account_number',
        'created_by',
        'updated_by',
    ];

    public function banking_informationable(): MorphTo
    {
        return $this->morphTo();
    }
}
