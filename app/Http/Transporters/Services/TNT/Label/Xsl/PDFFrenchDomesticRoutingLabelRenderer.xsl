<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:fo="http://www.w3.org/1999/XSL/Format"
                xmlns:fox="http://xmlgraphics.apache.org/fop/extensions"> 

<xsl:template name="FrenchDomesticPdf">

	<fo:block-container break-before="page" 
	                    border-style="solid"
	                    border-width="1"
	                    border-collapse="collapse"
	                    font-family="sans-serif"
	                    top="0px"
	                    left="0px"
	                    width="396px"
	                    height="578px"> 

		<!-- Logo-->
		<fo:block-container absolute-position="absolute" 
			                top="5px" 
			                left="305px">
			<fo:block>
			    <fo:external-graphic src="url('{$images_dir}/logo.jpg')" content-height="30px"/>
			</fo:block>
		</fo:block-container>
		
		<fo:block-container absolute-position="absolute"
		                    top="5px"
		                    left="10px"
		                    width="131px"
		                    height="10px"
		                    padding-left="3px"
		                    padding-top="1px"
		                    border-width="1px"
		                    border-top-style="none"
		                    border-left-style="none"
		                    border-right-style="none"> 
		    <fo:block font-size="9px"> 
		        <xsl:if test="string-length(../consignmentLabelData/account/accountNumber) > 0">
		          Nr Compte TNT : <xsl:value-of select="../consignmentLabelData/account/accountNumber" />
		        </xsl:if>
		    </fo:block>
		</fo:block-container>
		
		<fo:block-container absolute-position="absolute"
		                    top="17px"
		                    left="10px"
		                    width="131px"
		                    height="10px"
		                    padding-left="3px"
		                    padding-top="1px"
		                    border-width="1px"
		                    border-top-style="none"
		                    border-left-style="none"
		                    border-right-style="none"> 
		    <fo:block font-size="9px"> 
		        <xsl:if test="string-length(../consignmentLabelData/sender/name) > 0">
		          Exp :  <xsl:value-of select="../consignmentLabelData/sender/name" />
		        </xsl:if>
		    </fo:block>
		</fo:block-container>
		
		<fo:block-container absolute-position="absolute"
		                    top="28px"
		                    left="32px"
		                    width="131px"
		                    height="30px"
		                    padding-left="3px"
		                    padding-top="1px"
		                    border-width="1px"
		                    border-top-style="none"
		                    border-left-style="none"
		                    border-right-style="none">	     
		    <fo:block font-size="9px"> 
		        <xsl:if test="string-length(../consignmentLabelData/sender/addressLine1) > 0">
		           <xsl:value-of select="../consignmentLabelData/sender/addressLine1" />
		        </xsl:if>
		    </fo:block> 
		    <fo:block font-size="9px"> 
		        <xsl:if test="string-length(../consignmentLabelData/sender/addressLine2) > 0">
		           <xsl:value-of select="../consignmentLabelData/sender/addressLine2" />
		        </xsl:if>
		    </fo:block> 
		    <fo:block font-size="9px">		    
		       <xsl:value-of select="../consignmentLabelData/sender/postcode" /><xsl:text>  </xsl:text>
		        - 		       
		       <xsl:value-of select="../consignmentLabelData/sender/town" /><xsl:text>  </xsl:text>
		    </fo:block>
		</fo:block-container>
		
		<fo:block-container absolute-position="absolute"
		                    top="57px"
		                    left="10px"
		                    width="131px"
		                    height="10px"
		                    padding-left="3px"
		                    padding-top="1px"
		                    border-width="1px"
		                    border-top-style="none"
		                    border-left-style="none"
		                    border-right-style="none"> 
		    <fo:block font-size="9px"> 
		          Tel : 
		    </fo:block>
		</fo:block-container> 
		
		<fo:block-container absolute-position="absolute"
		                    top="130px"
		                    left="10px"
		                    width="250px"
		                    height="10px"
		                    padding-left="3px"
		                    padding-top="1px"
		                    font-weight="bold"
		                    border-width="1px"
		                    border-top-style="none"
		                    border-left-style="none"
		                    border-right-style="none"> 
		    <fo:block font-size="10px"> 
		          Adresse de Livraison :
		    </fo:block>
		    
		    <xsl:if test="string-length(../consignmentLabelData/delivery/name) > 0">
		        <fo:block font-size="10px">
		           <xsl:value-of select="../consignmentLabelData/delivery/name" />
		        </fo:block> 
		    </xsl:if>
		    <fo:block font-size="10px"> 
		        <xsl:if test="string-length(../consignmentLabelData/delivery/addressLine1) > 0">
		           <xsl:value-of select="../consignmentLabelData/delivery/addressLine1" />
		        </xsl:if>
		    </fo:block> 
		    <xsl:if test="string-length(../consignmentLabelData/delivery/addressLine2) > 0">
		    <fo:block font-size="10px"> 
		           <xsl:value-of select="../consignmentLabelData/delivery/addressLine2" />
		    </fo:block> 
		    </xsl:if>
		    <fo:block font-size="18px" padding-top="5px"> 
		       <xsl:value-of select="../consignmentLabelData/delivery/postcode" /><xsl:text>  </xsl:text>
		        - 
		       <xsl:value-of select="../consignmentLabelData/delivery/town" />
		    </fo:block> 
		    
		</fo:block-container> 
		
		<fo:block-container absolute-position="absolute"
		                    top="140px"
		                    left="150px"
		                    width="131px"
		                    height="10px"
		                    padding-left="3px"
		                    padding-top="1px"
		                    border-width="1px"
		                    border-top-style="none"
		                    border-left-style="none"
		                    border-right-style="none"> 
		    <fo:block font-size="8px">
		    	<xsl:if test="string-length(../consignmentLabelData/contact/telephoneNumber) > 0">
		    		Tel : <xsl:value-of select="../consignmentLabelData/contact/telephoneNumber" />
		    	</xsl:if>
		    </fo:block>  
		</fo:block-container>
		
		<fo:block-container absolute-position="absolute"
		                    top="207px"
		                    left="10px"
		                    width="250px"
		                    height="10px"
		                    padding-left="3px"
		                    padding-top="1px"
		                    font-weight="bold"
		                    border-width="1px"
		                    border-top-style="none"
		                    border-left-style="none"
		                    border-right-style="none"> 
		    <fo:block font-size="10px">
		    	<xsl:if test="string-length(../consignmentLabelData/contact/name) > 0">
		    		<xsl:value-of select="../consignmentLabelData/contact/name" />
		    	</xsl:if>
		    </fo:block>
		    <fo:block font-size="10px">
		    	<xsl:if test="string-length(../consignmentLabelData/specialInstructions) > 0">
		    		<xsl:value-of select="../consignmentLabelData/specialInstructions" />
		    	</xsl:if>
		    </fo:block>   
		</fo:block-container>
		
		<fo:block-container absolute-position="absolute"
		                    top="57px"
		                    left="280px"
		                    width="131px"
		                    height="10px"
		                    padding-left="3px"
		                    padding-top="1px"
		                    border-width="1px"
		                    border-top-style="none"
		                    border-left-style="none"
		                    white-space-collapse="false"
		                    border-right-style="none"> 
		    <fo:block font-size="9px"> 
		          WEB       : www.tnt.fr 
		    </fo:block>
		    <fo:block font-size="9px" padding-top="8px"> 
		          Ref         : <xsl:value-of select="../pieceLabelData/pieceReference" />
		    </fo:block>
		    <fo:block font-size="9px"> 
		          Colis       : <xsl:value-of select="../pieceLabelData/pieceNumber" /> / <xsl:value-of select="../consignmentLabelData/totalNumberOfPieces" />  
		    </fo:block>
		    <fo:block font-size="9px"> 
		          Poids      : <xsl:value-of select="../pieceLabelData/weightDisplay" />
		    </fo:block>
		    <fo:block font-size="9px"> 
		          Le           : <xsl:value-of select="../consignmentLabelData/collectionDate" />
		    </fo:block>
		</fo:block-container> 
		
		<fo:block-container absolute-position="absolute"
		                    top="220px"
		                    left="380px"
		                    width="90px"
		                    height="10px"
		                    padding-left="3px"
		                    padding-top="1px"
		                    font-weight="bold"
		                    border-width="1px"
		                    border-top-style="none"
		                    border-left-style="none"
		                    border-right-style="none"
		                    fox:transform="rotate(270)"> 
		    <fo:block font-size="8px">
		    	Ver : 110414
		    </fo:block>   
		</fo:block-container>
			            
	</fo:block-container>  
   
</xsl:template> 

<xsl:template name="FormatDateFrenchDomestic">
    <!-- expected date format 2008 06 16 -->
    <xsl:param name="DateTime" />
    <!-- new date format 20 June 2007 -->
    <xsl:variable name="year">
        <xsl:value-of select="substring-before($DateTime,'-')" />
    </xsl:variable>
    <xsl:variable name="mo-temp">
        <xsl:value-of select="substring-after($DateTime,'-')" />
    </xsl:variable>
    <xsl:variable name="mo">
        <xsl:value-of select="substring-before($mo-temp,'-')" />
    </xsl:variable>
    <xsl:variable name="day">
        <xsl:value-of select="substring-after($mo-temp,'-')" />
    </xsl:variable>

    <xsl:value-of select="$day" />
    <xsl:text> </xsl:text>
    <xsl:choose>
        <xsl:when test="$mo = '1' or $mo = '01'">01</xsl:when>
        <xsl:when test="$mo = '2' or $mo = '02'">02</xsl:when>
        <xsl:when test="$mo = '3' or $mo = '03'">03</xsl:when>
        <xsl:when test="$mo = '4' or $mo = '04'">04</xsl:when>
        <xsl:when test="$mo = '5' or $mo = '05'">05</xsl:when>
        <xsl:when test="$mo = '6' or $mo = '06'">06</xsl:when>
        <xsl:when test="$mo = '7' or $mo = '07'">07</xsl:when>
        <xsl:when test="$mo = '8' or $mo = '08'">08</xsl:when>
        <xsl:when test="$mo = '9' or $mo = '09'">09</xsl:when>
        <xsl:when test="$mo = '10'">10</xsl:when>
        <xsl:when test="$mo = '11'">11</xsl:when>
        <xsl:when test="$mo = '12'">12</xsl:when>
    </xsl:choose>
    <xsl:text> </xsl:text>
    <xsl:value-of select="$year" />
</xsl:template>
 
</xsl:stylesheet>
