USE SIS_TMT
GO
DELETE FROM Permiso.Motivos
GO
DBCC CHECKIDENT ('Permiso.Motivos', RESEED, 1)
GO