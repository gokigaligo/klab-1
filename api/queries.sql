
-- TOTAL COLLECTIONS
SELECT g.groupId, g.accountNumber, 
IFNULL(
		(
			SELECT sum(t.amount) 
			FROM rtgs.transactions t 
			WHERE ((t.status = 'APPROVED' AND t.operation = 'DEBIT') AND (t.forGroupId = g.groupId))
		),0
		) AS Balance 
	FROM rtgs.groups g

-- TOTAL WITHDRAL
SELECT g.groupId, g.accountNumber, 
IFNULL(
		(
			SELECT sum(t.amount) 
			FROM rtgs.transactions t 
			WHERE ((t.status = 'APPROVED' AND t.operation = 'CREDIT') AND (t.forGroupId = g.groupId))
		),0
		) AS Balance 
	FROM rtgs.groups g