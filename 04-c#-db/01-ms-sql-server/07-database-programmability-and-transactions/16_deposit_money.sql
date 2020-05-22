CREATE PROCEDURE usp_DepositMoney(
    @accountId INT,
    @moneyAmount DECIMAL(18, 4))
AS

IF (@moneyAmount <= 0) RETURN

UPDATE Accounts
SET Balance += @moneyAmount
WHERE Id = @accountId