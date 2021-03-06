SELECT 
	TOP 10 [Permiso].[id] AS [Permiso__id],
	[Permiso].[destino] AS [Permiso__destino],
	[Permiso].[fecha_permiso] AS [Permiso__fecha_permiso],
	[Permiso].[hora_salida] AS [Permiso__hora_salida],
	[Permiso].[hora_retorno] AS [Permiso__hora_retorno],
	[Permiso].[motivo_id] AS [Permiso__motivo_id],
	[Permiso].[Per_DNI] AS [Permiso__Per_DNI],
	CONVERT(VARCHAR(20), [Permiso].[created], 20) AS [Permiso__created],
	[Permiso].[estado] AS [Permiso__estado],
	[Motivo].[id] AS [Motivo__id],
	[Motivo].[descripcion] AS [Motivo__descripcion],
	[Motivo].[descuento] AS [Motivo__descuento],
	[Motivo].[estado] AS [Motivo__estado],
	(CASE WHEN descuento = '1' THEN 'Si' ELSE 'No' END) AS [Motivo__descuento_view]
FROM 
	[Permiso].[permisos] AS [Permiso] LEFT JOIN
	[Permiso].[motivos] AS [Motivo] ON ([Permiso].[motivo_id] = [Motivo].[id]) 
WHERE
	[Permiso].[estado] = N'1' AND 
	[Permiso].[Per_DNI] IN (N'04206862') 
ORDER BY 
	[Permiso].[id] asc