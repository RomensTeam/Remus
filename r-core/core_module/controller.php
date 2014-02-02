NT ID="NavBarFont1"><B>Deprecated</B></FONT></A>&nbsp;</TD>
  <TD BGCOLOR="#EEEEFF" CLASS="NavBarCell1">    <A HREF="../../index-all.html"><FONT ID="NavBarFont1"><B>Index</B></FONT></A>&nbsp;</TD>
  <TD BGCOLOR="#EEEEFF" CLASS="NavBarCell1">    <A HREF="../../help-doc.html"><FONT ID="NavBarFont1"><B>Help</B></FONT></A>&nbsp;</TD>
  </TR>
</TABLE>
</TD>
<TD ALIGN="right" VALIGN="top" ROWSPAN=3><EM>
1.60.0</EM>
</TD>
</TR>

<TR>
<TD BGCOLOR="white" CLASS="NavBarCell2"><FONT SIZE="-2">
&nbsp;<A HREF="../../interbase/interclient/LockConflictException.html"><B>PREV CLASS</B></A>&nbsp;
&nbsp;<A HREF="../../interbase/interclient/ParameterConversionException.html"><B>NEXT CLASS</B></A></FONT></TD>
<TD BGCOLOR="white" CLASS="NavBarCell2"><FONT SIZE="-2">
  <A HREF="../../index.html" TARGET="_top"><B>FRAMES</B></A>  &nbsp;
&nbsp;<A HREF="OutOfMemoryException.html" TARGET="_top"><B>NO FRAMES</B></A></FONT></TD>
</TR>
<TR>
<TD VALIGN="top" CLASS="NavBarCell3"><FONT SIZE="-2">
  SUMMARY: &nbsp;INNER&nbsp;|&nbsp;FIELD&nbsp;|&nbsp;CONSTR&nbsp;|&nbsp;<A HREF="#methods_inherited_from_class_java.sql.SQLException">METHOD</A></FONT></TD>
<TD VALIGN="top" CLASS="NavBarCell3"><FONT SIZE="-2">
DETAIL: &nbsp;FIELD&nbsp;|&nbsp;CONSTR&nbsp;|&nbsp;METHOD</FONT></TD>
</TR>
</TABLE>
<!-- =========== END OF NAVBAR =========== -->

<HR>
<!-- ======== START OF CLASS DATA ======== -->
<H2>
<FONT SIZE="-1">
interbase.interclient</FONT>
<BR>
Class  OutOfMemoryException</H2>
<PRE>
<A HREF="http://java.sun.com/products/jdk/1.2/docs/api/java/lang/Object.html">java.lang.Object</A>
  |
  +--<A HREF="http://java.sun.com/products/jdk/1.2/docs/api/java/lang/Throwable.html">java.lang.Throwable</A>
        |
        +--<A HREF="http://java.sun.com/products/jdk/1.2/docs/api/java/lang/Exception.html">java.lang.Exception</A>
              |
              +--<A HREF="http://java.sun.com/products/jdk/1.2/docs/api/java/sql/SQLException.html">java.sql.SQLException</A>
                    |
                    +--interbase.interclient.SQLException
                          |
                          +--<B>interbase.interclient.OutOfMemoryException</B>
</PRE>
<HR>
<DL>
<DT>public final class <B>OutOfMemoryException</B><DT>extends interbase.interclient.SQLException</DL>

<P>
InterBase or InterServer host memory has been exhausted.
 <p>
 The error codes associated with this exception are
 <A HREF="../../interbase/interclient/ErrorCodes.html#outOfMemory"><CODE>ErrorCodes.outOfMemory</CODE></A> for driver generated bug checks,
 or isc_bufexh, isc_virmemexh from the ibase.h file for 
 an InterBase generated license error.
<P>
<DL>
<DT><B>Since: </B><DD><font color=red>Extension, since InterClient 1.0</font></DD>
<DT><B>See Also: </B><DD><A HREF="../../serialized-form.html#interbase.interclient.OutOfMemoryException">Serialized Form</A></DL>
<HR>

<P>
<!-- ======== INNER CLASS SUMMARY ======== -->


<!-- =========== FIELD SUMMARY =========== -->


<!-- ======== CONSTRUCTOR SUMMARY ======== -->


<!-- ========== METHOD SUMMARY =========== -->

<