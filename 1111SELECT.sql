SELECT
    mt.id AS transaction_id,
    mt.app_user_id,
    mt.introducer_id,
    au.introducer_name AS introducer_name,
    pm.select_plan AS introducer_plan,
    pm.plan_level AS introducer_rank,
    mt.amount,
    mt.created_at
FROM
    mlm_transactions mt
    LEFT JOIN app_users au ON mt.introducer_id = au.id
    LEFT JOIN plan_master pm ON au.select_plan_id = pm.select_plan_id
WHERE
    mt.app_user_id = 44
ORDER BY mt.created_at DESC
LIMIT 500;

SELECT
    mt.id AS transaction_id,
    mt.app_user_id,
    mt.introducer_id,
    au.introducer_name AS introducer_name,
    pm.select_plan AS introducer_plan,
    pm.plan_level AS introducer_rank,
    mt.amount,
    mt.created_at
FROM
    mlm_transactions mt
    LEFT JOIN app_users au ON mt.introducer_id = au.id
    LEFT JOIN plan_master pm ON au.select_plan_id = pm.id;