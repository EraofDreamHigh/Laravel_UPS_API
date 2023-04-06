<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:fo="http://www.w3.org/1999/XSL/Format"
                xmlns:url="http://whatever/java/java.net.URLEncoder"> 
                
<xsl:template name="RestOfWorldPdf"> 
    
	<fo:block-container break-before="page" 
	                    border-style="solid"
	                    border-width="1px" 
	                    border-collapse="collapse"
	                    font-family="sans-serif"
	                    top="0px"
	                    left="0px"
	                    width="270px"
	                    height="405px"> 
	
	     <!-- Logo-->
	     <fo:block-container absolute-position="absolute" 
	                         top="5px" 
		                     left="3px">
		     <fo:block>
		         <fo:external-graphic src="url('{$images_dir}/logo.jpg')"
		                               content-height="25px"/>
		     </fo:block>
	     </fo:block-container>
	     
	     <!-- Market & Transport Type -->       
	     <fo:block-container
	               absolute-position="absolute" 
	               top="0px"
	               left="85px">  
		     <fo:block font-weight="bold"
		               font-size="14pt"
		               text-align="left"
		               padding-top="2px"> 
		        <fo:inline padding-left="1px">
		        <xsl:value-of select="../consignmentLabelData/marketDisplay"/>
		        </fo:inline>
		        <xsl:text>/</xsl:text>
		        <fo:inline>
		        <xsl:value-of select="../consignmentLabelData/transportDisplay" />          
		        </fo:inline>
		     </fo:block>
	     </fo:block-container>
  
         <!-- X-RAY -->
         <fo:block-container
                   absolute-position="absolute" 
                   top="0px"
                   left="150px">  
	         <fo:block font-weight="bold"
	                   font-size="14pt"
	                   text-align="left"
	                   padding-top="2px"> 
	            <fo:inline padding-left="1px">
	              <xsl:value-of select="../consignmentLabelData/xrayDisplay"/>          
	            </fo:inline>
	         </fo:block>
         </fo:block-container>
  
         <!-- Hazardous -->
         <xsl:for-each select="../consignmentLabelData/option">
             <xsl:if test="@id='HZ'">
		         <fo:block-container
		                   absolute-position="absolute" 
		                   top="18px"
		                   left="85px"
		                   height="21px" 
		                   width="111px"
		                   background-color="black">  
			         <fo:block font-weight="bold"
			                   color="#FFFFFF"
			                   font-size="14pt"
			                   text-align="center"
			                   padding-top="3px"> 
			            <fo:inline>
	                        <xsl:text>HAZARDOUS</xsl:text>            
			            </fo:inline>
			         </fo:block>
		         </fo:block-container>
             </xsl:if>
         </xsl:for-each>   
	
	     
	     <!-- Free Circulation Indicator --> 
	     <fo:block-container absolute-position="absolute" 
	                         top="0px"
	                         left="205px"
	                         height="39px"
	                         width="31px"
	                         background-color="black">
		     <fo:block font-weight="bold" 
		               line-height="80%"
		               padding-top="10px"
		               color="#FFFFFF"
		               font-size="35px"
		               text-align="center"> 
		        <xsl:value-of select="../consignmentLabelData/freeCirculationDisplay" />                                    
		     </fo:block>
	     </fo:block-container>
	
	     <!-- Sort Split Indicator -->
	     <fo:block-container absolute-position="absolute" 
	                         top="0px"
	                         left="238px"
	                         height="39px"
	                         width="31px">
		     <fo:block font-weight="bold"
	                   line-height="80%"
	                   padding-top="10px"
		               font-size="35px"
		               text-align="center"> 
		        <xsl:value-of select="../consignmentLabelData/sortSplitText" />
		     </fo:block>
	     </fo:block-container>
         
         
         <!-- TwoD Barcode-->
         <fo:block-container absolute-position="absolute"
                             top="50px"
                             left="0px"
                             width="270px"
                             height="70px">
			<fo:block text-align="center">
				<fo:external-graphic content-height="100%" content-width="260">
				<xsl:attribute name="src">
				url('<xsl:value-of select="concat($twoDbarcode_url,url:encode(twoDBarcode))" />')
				     </xsl:attribute>
				</fo:external-graphic>  
			</fo:block>
		</fo:block-container> 

	
	     <!-- Con Number -->
	     <fo:block-container absolute-position="absolute"
	                         top="117px"
	                         left="3px"
	                         width="132px"
	                         height="35px"
	                         padding-left="3px">
		     <fo:block>
	            <fo:inline font-size="8px" vertical-align="top">Con No. </fo:inline>
	            <fo:inline font-size="18px" font-weight="bold"> 
	                <xsl:text> </xsl:text><xsl:value-of select="../consignmentLabelData/consignmentNumber" />
	            </fo:inline>                    
		     </fo:block> 
	     </fo:block-container>
                 
    
         <!-- Origin Depot-->
         <fo:block-container absolute-position="absolute"
                             top="117px"
                             left="136px"
                             width="67px"
                             height="25px"
                             start-indent="3px"> 
	         <fo:block>
	            <fo:inline font-size="8px" vertical-align="top">Origin  </fo:inline>
	            <fo:inline font-size="16px" font-weight="bold"> 
	                <xsl:value-of select="../consignmentLabelData/originDepot/depotCode" />
	            </fo:inline>                                    
	         </fo:block> 
         </fo:block-container> 
         
    
         <!-- Pickup Date-->
         <fo:block-container absolute-position="absolute"
                             top="117px"
                             left="207px"
                             width="63px"
                             height="25px">
	         <fo:block font-size="8px" >Pickup Date</fo:block> 
	         <fo:block font-size="8px"> 
	           <xsl:call-template name="FormatDate">    
	             <xsl:with-param name="DateTime" select="../consignmentLabelData/collectionDate"/> 
	           </xsl:call-template>                                      
	         </fo:block> 
         </fo:block-container>
	     
	     
	     <!-- Piece-->
	     <fo:block-container absolute-position="absolute"
	                         top="137px"
	                         left="3px"
	                         width="67px"
	                         height="25px"
	                         line-height="75%"
	                         padding-left="3px">
		     <fo:block font-size="8pt"> 
		        <fo:inline>Piece</fo:inline> 
		     </fo:block> 
		     <fo:block font-weight="bold"
		               font-size="14pt"
		               line-height="100%"> 
		        <fo:inline><xsl:value-of select="pieceNumber" />
		           of 
		           <xsl:value-of select="../consignmentLabelData/totalNumberOfPieces" /></fo:inline>
		        
		     </fo:block> 
	     </fo:block-container>
	                
	     <!-- Weight -->
	     <fo:block-container absolute-position="absolute"
	                         top="137px"
	                         left="70px"
	                         height="25px"
	                         line-height="75%">
		     <fo:block font-size="8pt"> 
		        <fo:inline>Weight</fo:inline> 
		     </fo:block> 
		     <fo:block font-weight="bold"
		               font-size="14pt"
		               line-height="100%"> 
		         <xsl:choose>
		             <xsl:when test="weightDisplay/@renderInstructions='highlighted'">
		                <fo:inline background-color="black" color="white">
		                    <xsl:value-of select="weightDisplay" />
		                </fo:inline>
		             </xsl:when>
		             <xsl:otherwise>
		                <fo:inline>
		                    <xsl:value-of select="weightDisplay" />
		                </fo:inline>
		             </xsl:otherwise>
		         </xsl:choose>
		     </fo:block>
	     </fo:block-container>
    
         <!-- Service -->
         <fo:block-container absolute-position="absolute"
                             top="163px"
                             left="2px"
                             width="133px"
                             height="15px"
                             line-height="70%"
                             padding-top="2px"
                             padding-left="2px"
                             background-color="#000000">
    
             <xsl:choose>
                 <xsl:when
                     test="string-length(../consignmentLabelData/product)>12">
    
                     <fo:block font-size="11pt"
                         font-weight="bold" color="#FFFFFF" line-height="100%">
                         <xsl:value-of select="../consignmentLabelData/product" />
                     </fo:block>
                 </xsl:when>
                 <xsl:otherwise>
    
                     <fo:block font-size="14pt"
                         font-weight="bold" color="#FFFFFF" line-height="100%">
                         <xsl:value-of select="../consignmentLabelData/product" />
                     </fo:block>
                 </xsl:otherwise>
             </xsl:choose>
    
         </fo:block-container>
    
         <!-- Options-->
         <fo:block-container absolute-position="absolute"
                             top="180px"
                             left="2px"
                             width="133px"
                             height="13px"
                             line-height="75%"
                             padding-left="2px"
                             padding-top="2px"
                             background-color="#000000">         
         <xsl:variable name="numberOptions"
                       select="count(../consignmentLabelData/option)" />
    
         <xsl:choose>
            <xsl:when
                test="$numberOptions >1">
                <fo:block font-size="12pt"
                    padding-top="2px" font-weight="bold"
                    color="#FFFFFF"
                    line-height="70%">
                    <xsl:for-each
                        select="../consignmentLabelData/option">
                        <fo:inline>
                            <xsl:value-of
                                select="@id" />
                            <xsl:text>  </xsl:text>
                        </fo:inline>
                    </xsl:for-each>
                </fo:block>
            </xsl:when>
            <xsl:otherwise>
                <xsl:choose>
                    <xsl:when
                        test="string-length(../consignmentLabelData/option)>19">
                        <fo:block
                            font-size="10pt" padding-top="2px"
                            text-align="left"
                            font-weight="bold"
                            color="#FFFFFF"
                            line-height="70%">
                            <xsl:value-of select="../consignmentLabelData/option" />
                        </fo:block>
                    </xsl:when>
                    <xsl:otherwise>
                        <fo:block
                            font-size="12pt" padding-top="2px"
                            text-align="left"
                            font-weight="bold"
                            color="#FFFFFF"
                            line-height="70%">
                            <xsl:value-of select="../consignmentLabelData/option" />
                        </fo:block>
                    </xsl:otherwise>
                </xsl:choose>
    
            </xsl:otherwise>
         </xsl:choose>
         </fo:block-container>
	     
	     <!-- Delivery Address-->
	     <fo:block-container absolute-position="absolute"
	                         top="197px"
	                         left="3px"
	                         width="133px"
	                         padding-left="3px">
		     <fo:block font-size="8px">Delivery Address</fo:block>
		     
		     <fo:block start-indent="6px"
		               font-size="8px"> 
		        <xsl:value-of select="../consignmentLabelData/delivery/name" />
		        
		     </fo:block> 
		     <fo:block start-indent="6px"
		               font-size="8px"> 
		        <xsl:value-of select="../consignmentLabelData/delivery/addressLine1" />
		        
		     </fo:block> 
		     <fo:block start-indent="6px"
		               font-size="8px"> 
		        <xsl:value-of select="../consignmentLabelData/delivery/addressLine2" />
		        
		     </fo:block> 
		     <fo:block start-indent="6px"
		               font-size="8px"> 
		        <xsl:value-of select="../consignmentLabelData/delivery/town" /><xsl:text>  </xsl:text>
		        
		        <xsl:value-of select="../consignmentLabelData/delivery/postcode" />
		        
		     </fo:block> 
		     <fo:block start-indent="6px"
		               font-size="8px"> 
		        <xsl:value-of select="../consignmentLabelData/delivery/country" />
		        
		     </fo:block> 
	     </fo:block-container> 
	
	     <!-- Route-->
	     <fo:block-container absolute-position="absolute"
	                         top="137px"
	                         left="138px"
	                         width="133px"
	                         height="96px"
	                         padding-left="3px"
	                         padding-top="2px">
	                         
	       <fo:block font-size="8px">Routing</fo:block>
	     </fo:block-container> 
	
	     <fo:block-container absolute-position="absolute"
	                         top="140px"
	                         left="153px"
	                         width="118px"
	                         height="96px"
	                         padding-left="3px"
	                         padding-top="2px">
		     <xsl:for-each select="../consignmentLabelData/transitDepots/*">
		
		         <xsl:if test="name(self::node()[position()])='transitDepot'">
		             <fo:block font-size="24pt"
		                 font-weight="bold" 
		                 start-indent="28px"
		                 line-height="95%">
		                 <xsl:value-of select="depotCode" />
		             </fo:block>
		         </xsl:if>
		
		         <xsl:if test="name(self::node()[position()])='actionDepot'">
		             <fo:block font-size="24pt"
		                 font-weight="bold" 
		                 start-indent="28px"
		                 line-height="95%">
		                 <xsl:value-of select="depotCode" />
		                 <xsl:text>-</xsl:text>
		                 <xsl:value-of select="actionDayOfWeek" />
		             </fo:block>
		         </xsl:if>
		
		         <xsl:if test="name(self::node()[position()])='sortDepot'">
		             <fo:block font-size="24pt"
		                 font-weight="bold" 
		                 start-indent="28px"
		                 line-height="95%">
		                 <xsl:value-of select="depotCode" />
		                 <xsl:text>-</xsl:text>
		                 <xsl:value-of select="sortCellIndicator" />
		             </fo:block>
		         </xsl:if>
		
		     </xsl:for-each>
		     <!-- Required to handle scenario where no transit depots in route-->
		     <fo:block>
		         <xsl:text> </xsl:text>
		     </fo:block>
	     </fo:block-container>
	     
	     <!--Sort Details-->
	     <fo:block-container absolute-position="absolute"
	                         top="234px"
	                         left="135px"
	                         width="136px"
	                         height="23px"
	                         start-indent="3px">
		     <fo:block>
		         <fo:inline font-size="8px" vertical-align="top">Sort </fo:inline>
		         <fo:inline font-size="20px" font-weight="bold" padding-top="10px" padding-left="15px">
		             <xsl:value-of select="../consignmentLabelData/transitDepots/sortDepot/depotCode" />
		         </fo:inline>
		     </fo:block>
	     </fo:block-container>
	     
	     <!-- Postcode / Cluster Detail -->
	     <fo:block-container absolute-position="absolute"
	                         top="254px"
	                         left="5px"
	                         width="130px"
	                         height="26px"
	                         padding-left="5px"
	                         background-color="black">
             <fo:block padding-top="2px"
                       font-weight="bold"
                       font-size="20px" 
                       color="#FFFFFF">
                 <xsl:value-of select="../consignmentLabelData/clusterCode" />
             </fo:block>
	     </fo:block-container>
	
	     
	     <!-- Destination Depot -->
	     <fo:block-container absolute-position="absolute"
	                         top="258px"
	                         left="135px"
	                         width="35px"
	                         height="24px"
	                         start-indent="3px">
		     <fo:block font-size="8px">Dest</fo:block>
		     <fo:block font-size="8px">Depot</fo:block> 
	     </fo:block-container> 
	     
	     <!-- Destination Depot Detail -->
	     <fo:block-container absolute-position="absolute"
	                         top="256px"
	                         left="166px"
	                         width="104px"
	                         height="28px">
	         <fo:block font-size="22pt" font-weight="bold"> 
		        <xsl:value-of select="../consignmentLabelData/destinationDepot/depotCode" />                                    
		          <xsl:text>   </xsl:text> 
		        <xsl:value-of select="../consignmentLabelData/destinationDepot/dueDayOfMonth" />
		     </fo:block> 
	     </fo:block-container> 
	     
	     <!-- Barcode-->
	     <fo:block-container absolute-position="absolute"
	                         top="292px"
	                         left="0px"
	                         width="270px">
		      <fo:block text-align="center">
		          <fo:external-graphic content-width="260px" content-height="100px">
		               <xsl:attribute name="src">
		                 url('<xsl:value-of select="concat($barcode_url,barcode)" />')
		               </xsl:attribute> 
		          </fo:external-graphic>  
		      </fo:block>
	     </fo:block-container> 
	     <fo:block-container absolute-position="absolute"
	                         top="392px"
	                         left="0px"
	                         width="270px">
		      <fo:block text-align="center">
		         <xsl:value-of select="barcode" />
		     </fo:block>
	     </fo:block-container> 
	  
	</fo:block-container>  
   
</xsl:template>

<xsl:template name="FormatDate">
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
        <xsl:when test="$mo = '1' or $mo = '01'">Jan</xsl:when>
        <xsl:when test="$mo = '2' or $mo = '02'">Feb</xsl:when>
        <xsl:when test="$mo = '3' or $mo = '03'">Mar</xsl:when>
        <xsl:when test="$mo = '4' or $mo = '04'">Apr</xsl:when>
        <xsl:when test="$mo = '5' or $mo = '05'">May</xsl:when>
        <xsl:when test="$mo = '6' or $mo = '06'">Jun</xsl:when>
        <xsl:when test="$mo = '7' or $mo = '07'">Jul</xsl:when>
        <xsl:when test="$mo = '8' or $mo = '08'">Aug</xsl:when>
        <xsl:when test="$mo = '9' or $mo = '09'">Sep</xsl:when>
        <xsl:when test="$mo = '10'">Oct</xsl:when>
        <xsl:when test="$mo = '11'">Nov</xsl:when>
        <xsl:when test="$mo = '12'">Dec</xsl:when>
    </xsl:choose>
    <xsl:text> </xsl:text>
    <xsl:value-of select="$year" />
</xsl:template>
 
</xsl:stylesheet>
