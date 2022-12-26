<?php

namespace Rabiloo\Searchy;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SearchyServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('searchy')
            ->hasConfigFile();
    }

    public function packageRegistered()
    {
        parent::packageRegistered();

        $this->app->singleton('searchy', function (Container $app) {
            $config = $app['config'];

            return new SearchyBuilder($config);
        });

        $this->app->alias('searchy', SearchyBuilder::class);

        $this->app->booted(function () {
            $mysql_version_check = DB::select(DB::raw('SHOW VARIABLES LIKE "version";'));
            $mysql_version = $mysql_version_check[0]->Value;
            if (substr($mysql_version, 2, 1) < '7' and substr($mysql_version, 4, 1) < '6') {
                $sql = 'CREATE FUNCTION IF NOT EXISTS levenshtein( s1 VARCHAR(255), s2 VARCHAR(255) )
                RETURNS INT
                DETERMINISTIC
                BEGIN
                    DECLARE s1_len, s2_len, i, j, c, c_temp, cost INT;
                    DECLARE s1_char CHAR;
                    -- max strlen=255
                    DECLARE cv0, cv1 VARBINARY(256);
                    SET s1_len = CHAR_LENGTH(s1), s2_len = CHAR_LENGTH(s2), cv1 = 0x00, j = 1, i = 1, c = 0;
                    IF s1 = s2 THEN
                        RETURN 0;
                    ELSEIF s1_len = 0 THEN
                        RETURN s2_len;
                    ELSEIF s2_len = 0 THEN
                        RETURN s1_len;
                    ELSE
                        WHILE j <= s2_len DO
                            SET cv1 = CONCAT(cv1, UNHEX(HEX(j))), j = j + 1;
                        END WHILE;
                        WHILE i <= s1_len DO
                            SET s1_char = SUBSTRING(s1, i, 1), c = i, cv0 = UNHEX(HEX(i)), j = 1;
                            WHILE j <= s2_len DO
                                SET c = c + 1;
                                IF s1_char = SUBSTRING(s2, j, 1) THEN
                                    SET cost = 0; ELSE SET cost = 1;
                                END IF;
                                SET c_temp = CONV(HEX(SUBSTRING(cv1, j, 1)), 16, 10) + cost;
                                IF c > c_temp THEN SET c = c_temp; END IF;
                                SET c_temp = CONV(HEX(SUBSTRING(cv1, j+1, 1)), 16, 10) + 1;
                                IF c > c_temp THEN
                                    SET c = c_temp;
                                END IF;
                                SET cv0 = CONCAT(cv0, UNHEX(HEX(c))), j = j + 1;
                            END WHILE;
                            SET cv1 = cv0, i = i + 1;
                        END WHILE;
                    END IF;
                    RETURN c;
                END;';
                DB::unprepared($sql);
            }
        });
    }

    public function provides()
    {
        return [
            'searchy',
        ];
    }
}
