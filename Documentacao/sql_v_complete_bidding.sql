select
    `ts`.`deleted_at` AS `ts_deleted_at`
    `bs`.`deleted_at` AS `bs_deleted_at`,
    `bf`.`pk_bidding` AS `pk_bidding`,
    `bf`.`bidding` AS `bidding`,
    `bf`.`not_fulfilled` AS `not_fulfilled`,
    `bf`.`priority` AS `priority`,
    `bf`.`sei` AS `sei`,
    `bf`.`created_at` AS `bf_created_at`,
    `bf`.`updated_at` AS `bf_updated_at`,
    `bf`.`deleted_at` AS `bf_deleted_at`,
    `bs`.`ID` AS `ID`,
    `bs`.`pk_stage` AS `bs_pk_stage`,
    `bs`.`orderc` AS `orderc`,
    `bs`.`made` AS `made`,
    `bs`.`justify` AS `justify`,
    `bs`.`date_start` AS `date_start`,
    `bs`.`date_end` AS `date_end`,
    `bs`.`deadline` AS `deadline`,
    `bs`.`created_at` AS `bs_created_at`,
    `bs`.`updated_at` AS `bs_updated_at`,
    `ts`.`pk_stage` AS `ts_pk_stage`,
    `ts`.`order` AS `order`,
    `ts`.`stage` AS `stage`,
    `ts`.`str_acronym` AS `str_acronym`,
    `ts`.`str_label` AS `str_label`,
    `ts`.`int_standard_term` AS `int_standard_term`,
    `ts`.`created_at` AS `ts_created_at`,
    `ts`.`updated_at` AS `ts_updated_at`,
from
    (
        (
            `tab_bidding_first` `bf`
            left join `tab_bidding_second` `bs` on ((`bf`.`pk_bidding` = `bs`.`pk_bidding`))
        )
        left join `tab_stage` `ts` on ((`bs`.`pk_stage` = `ts`.`pk_stage`))
    )
where
    (
        (`bf`.`deleted_at` is null)
        and (`bs`.`deleted_at` is null)
    )
order by
    `bf`.`priority`