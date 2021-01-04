<%
	i=hour(time)
	If i < 12 Then
		response.write("Good morning!")
	Else
		response.write("Have a nice day!")
	End If
%>