CREATE PROCEDURE usp_CalculateFutureValueForAccount(
    @accountId INT,
    @interestRate FLOAT)
AS
SELECT
    a.Id,
    ah.FirstName,
    ah.LastName,
    a.Balance,
    dbo.ufn_CalculateFutureValue(a.Balance, @interestRate, 5) AS [Balance in 5 years]
FROM
    Accounts a
    JOIN AccountHolders ah
    ON a.AccountHolderId = ah.Id
WHERE a.Id = @accountId