<% Option Explicit


Dim Filename 
'set Filename = request("caminho")
set Filename = "CB010900.RET"

Dim posicaoInicial
set posicaoInicial = request("ini")
Dim casas
set casas = request("casas")

Const ForReading = 1, ForWriting = 2, ForAppending = 3
Const TristateUseDefault = -2, TristateTrue = -1, TristateFalse = 0

' Create a filesystem object
Dim FSO
set FSO = server.createObject("Scripting.FileSystemObject")


' Map the logical path to the physical system path
Dim Filepath
Filepath = Filename

if FSO.FileExists(Filepath) Then

    ' Get a handle to the file
    Dim file    
    set file = FSO.GetFile(Filepath)

    ' Get some info about the file
    Dim FileSize
    FileSize = file.Size

    Response.Write "<p><b>File: " & Filename & " (size "& FileSize &" bytes)</b></p><hr>"
    ' Open the file
    Dim TextStream
    Set TextStream = file.OpenAsTextStream(ForReading, TristateUseDefault)

    ' Read the file line by line

    Dim linha
    linha = 0

    Dim posicaoValor 
    posicaoValor = 0
    %>
    <table>
        <tbody>
            <tr align="center">
                <td width="10%">Linha</td>
                <td width="10%">Tamanho</td>
                <td width="60%">Conteudo</td>
                <td width="10%"><%=posicaoInicial%> - <%=casas%></td>
            </tr><%
    Dim posicao 
    posicao = 0
    Do While Not TextStream.AtEndOfStream
        linha = linha + 1 
        Dim Line

        Line = TextStream.readline
    
        ' Do something with "Line"
        Line = Line & vbCRLF
    
        %>
            <tr>
                <td align="center"><%=linha%></td>
                <td align="center"><%=len(Line)%></td>
                <td align="left"><%=replace(Line," ","#")%></td>
                <td align="right"><label style="font-weight: bold;color:red;"><%=mid(Line,posicaoInicial,casas)%></label></td>
            </tr>
            <tr>
                <td align="center"><%=linha%></td>
                <td align="center" colspan="4">
                    <table  class="table table-bordered" style="overflow: auto;width: 1200px;">
                        <tbody >
                            <tr>
                                <td>
                                    Posi��es
                                </td>
                            <%
                                for posicao = 0 to len(Line)-2
                                    if posicao + 1 > len(Line)-2 then
                                        Exit For
                                    end if
                                    response.write "<td>"&posicao+1&"</td>"
                                
                                next
                            %>
                            </tr>
                            <tr>
                                <td>
                                    Valores
                                </td>
                            <%
                                for posicaoValor = 0 to len(Line)-2
                                    if posicaoValor + 1 > len(Line)-2 then
                                        Exit For
                                    end if
                                    response.write "<td>"&mid(Line,posicaoValor+1,1)&"</td>"
                                
                                next
                            %>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        <%
    Loop
    %>
        </tbody>
    </table>
    <%

    Response.Write "<hr>"

    Set TextStream = nothing
    
Else

    Response.Write "<h3><i><font color=red> Arquivo " & Filename &_
                       " n�o encontrado!</font></i></h3>"

End If

Set FSO = nothing
%>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">