SELECT SUM(UTT.payed_hours * URP.price_per_hour) as period_total_price, UTT.user_id, UTT.user_role_id, UTT.payed_hours, U.email AS user_email, UR.name AS role_name, URP.price_per_hour AS period_price_per_hour, URP.created_at AS period_created_at, URP.deprecated_at AS period_deprecated_at
FROM task AS T
JOIN user_to_task AS UTT ON (UTT.task_id = T.id)
JOIN users AS U ON (U.id = UTT.user_id)
JOIN user_role AS UR ON (UR.id = UTT.user_role_id)
JOIN user_role_price AS URP ON (URP.user_role_id = UR.id)

WHERE T.project_id = 48 
AND T.created_at >= URP.created_at 
AND T.created_at < URP.deprecated_at 

group by (UTT.user_id)
group by (UTT.user_role_id)