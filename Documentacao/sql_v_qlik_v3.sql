SELECT
    `bf`.`deleted_at` AS `bf_deleted_at`,
    `bs`.`deleted_at` AS `bs_deleted_at`,
    `bf`.`bidding` AS `Licitação`,
    `bf`.`priority` AS `Prioridade`,
    `bf`.`not_fulfilled` AS `Licitação sem atraso`,
    `bf`.`sei` AS `SEI`,
    `ts`.`order` AS `Ordem/Etapa`,
    `ts`.`stage` AS `Estado/Licitação`,
    `bs`.`date_start` AS `Início`,
    `bs`.`deadline` AS `Prazo`,
    `bs`.`justify` AS `Justificativa`,
    `bs`.`date_end` AS `Fim`,
    `bs`.`made` AS `Etapa sem atraso`
FROM
    `tab_bidding_first` `bf`
    JOIN `tab_bidding_second` `bs` ON `bf`.`pk_bidding` = `bs`.`pk_bidding`
    JOIN `tab_stage` `ts` ON `bs`.`pk_stage` = `ts`.`pk_stage`
WHERE
    `bf`.`deleted_at` IS NULL
    AND `bs`.`deleted_at` IS NULL
ORDER BY
    `bf`.`priority`,
    `ts`.`order`;
