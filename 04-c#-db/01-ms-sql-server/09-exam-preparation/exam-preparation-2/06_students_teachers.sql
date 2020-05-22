SELECT
  s.FirstName,
  s.LastName,
  COUNT(st.TeacherId)
FROM
  Students s
  JOIN StudentsTeachers st ON st.StudentId = s.Id
GROUP BY
  s.FirstName,
  s.LastName