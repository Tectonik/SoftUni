CREATE TABLE [Minions]
(
    [Id] INT PRIMARY KEY NOT NULL,
    [Name] NVARCHAR(50) NOT NULL,
    [Age] INT DEFAULT 0
)

CREATE TABLE [Towns]
(
    [Id] INT PRIMARY KEY NOT NULL,
    [Name] NVARCHAR(50) NOT NULL
)