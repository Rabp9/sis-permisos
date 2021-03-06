USE SIS_TMT
GO
SELECT 
	hc.Per_DNI, hc.Are_Codigo
FROM 
	RRHH.Historico_Cargo hc
WHERE 
	Anio_Codigo = '2015' AND 
	Hiscar_Estado = '00' AND 
	hc.Are_Codigo IN (SELECT
		ah.Are_Codigo
	FROM
		RRHH.Area ap INNER JOIN
		RRHH.Area ah ON ap.Are_Codigo = ah.Are_Padre
	WHERE
		ap.Are_Codigo = 6
	)
GO

SELECT
	ah.*
FROM
	RRHH.Area ap INNER JOIN
	RRHH.Area ah ON ap.Are_Codigo = ah.Are_Padre
WHERE
	ap.Are_Codigo = 6
GO